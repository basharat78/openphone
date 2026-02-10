<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Call;
use App\Models\Dispatcher;
use App\Models\QcScore;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Stats
        $totalCalls = Call::count();
        $scoredCalls = QcScore::count();
        $pendingCalls = $totalCalls - $scoredCalls;
       

        // Dispatcher Performance (All-time stats for the table)
        $dispatcherStats = Dispatcher::with('calls.qcScore')
            ->get()
            ->map(function ($dispatcher) {
                $scores = $dispatcher->calls->pluck('qcScore')->filter();
                $count = $scores->count();
                
                if ($count === 0) {
                    return [
                        'id' => $dispatcher->id,
                        'name' => $dispatcher->name,
                        'avg_score' => 0,
                        'total_calls' => $dispatcher->calls->count(),
                        'scored_calls' => 0
                    ];
                }

                // Calculate average across all 4 categories
                $totalScoreSum = $scores->sum(function ($score) {
                    return ($score->communication_score + $score->confidence_score + $score->professionalism_score + $score->closing_score) / 4;
                });

                return [
                    'id' => $dispatcher->id,
                    'name' => $dispatcher->name,
                    'avg_score' => round($totalScoreSum / $count, 2),
                    'total_calls' => $dispatcher->calls->count(),
                    'scored_calls' => $count
                ];
            });

        // Key the stats by ID for easy lookup
        $statsById = $dispatcherStats->keyBy('id');

        // Agent Performance Cards (Today's Data)
        $agentCards = Dispatcher::with(['calls' => function($q) {
                $q->whereDate('called_at', today());
            }, 'calls.qcScore', 'messages' => function($q) {
                $q->whereDate('sent_at', today());
            }])
            ->get()
            ->map(function ($dispatcher) use ($statsById) {
                $todayCalls = $dispatcher->calls;
                $totalCallsToday = $todayCalls->count();
                
                // Answered vs Missed
                $answeredCalls = $todayCalls->where('status', 'completed')->count();
                $missedCalls = $todayCalls->where('status', 'missed')->count();
                
                // Average call duration (in seconds)
                $avgDuration = $todayCalls->where('status', 'completed')->avg('duration') ?? 0;
                
                // Messages sent today
                $messagesSent = $dispatcher->messages->count();
                
                // QC Score (average of all scored calls for this dispatcher)
                // We take this from the global stats calculated above
                $avgQcScore = 0;
                if(isset($statsById[$dispatcher->id])) {
                    $avgQcScore = $statsById[$dispatcher->id]['avg_score'];
                }
                
                // Status Indicator Logic (green/yellow/red)
                $status = 'green'; // default
                if ($avgQcScore > 0 && $avgQcScore < 3.0 || $missedCalls > 3) {
                    $status = 'red';
                } elseif ($avgQcScore > 0 && $avgQcScore < 4.0 || $missedCalls > 1) {
                    $status = 'yellow';
                }
                
                return [
                    'id' => $dispatcher->id,
                    'name' => $dispatcher->name,
                    'total_calls_today' => $totalCallsToday,
                    'answered' => $answeredCalls,
                    'missed' => $missedCalls,
                    'avg_duration' => round($avgDuration),
                    'messages_sent' => $messagesSent,
                    'qc_score' => $avgQcScore,
                    'status' => $status,
                ];
            });

        return view('admin.dashboard.index', compact('totalCalls', 'scoredCalls', 'pendingCalls', 'agentCards', 'dispatcherStats'));
    }
}
