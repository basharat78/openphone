<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_calls' => 245,
            'scored_calls' => 187,
            'pending_reviews' => 58,
        ];
        
        $card = [
            [
                'id' => 1,
                'name' => 'John Smith',
                'status' => 'green',
                'total_calls_today' => 45,
                'answered' => 42,
                'missed' => 3,
                'avg_duration' => 245,
                'messages_sent' => 12,
                'qc_score' => 4.5,
            ],
            [
                'id' => 2,
                'name' => 'Sarah Johnson',
                'status' => 'yellow',
                'total_calls_today' => 38,
                'answered' => 35,
                'missed' => 3,
                'avg_duration' => 198,
                'messages_sent' => 8,
                'qc_score' => 3.8,
            ],
            [
                'id' => 3,
                'name' => 'Mike Davis',
                'status' => 'green',
                'total_calls_today' => 52,
                'answered' => 50,
                'missed' => 2,
                'avg_duration' => 267,
                'messages_sent' => 15,
                'qc_score' => 4.7,
            ],
        ];
        
        return view('admin.dashboard.index', compact('stats', 'card'));
    }
}
