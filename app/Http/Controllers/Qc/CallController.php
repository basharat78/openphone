<?php

namespace App\Http\Controllers\Qc;

use App\Http\Controllers\Controller;
use App\Models\Call;
use App\Models\QcScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class CallController extends Controller
{
    /**
     * Display the QC dashboard with statistics.
     */
    public function dashboard()
    {
        $stats = [
            'total_calls' => Call::count(),
            'reviewed_calls' => Call::has('qcScore')->count(),
            'pending_calls' => Call::doesntHave('qcScore')->count(),
            'avg_score' => \App\Models\QcScore::query()
                ->selectRaw('AVG((communication_score + confidence_score + professionalism_score + closing_score) / 4) as average')
                ->value('average') ?? 0,
        ];

        // Fetch recent scores
        $recentReviews = \App\Models\QcScore::with(['call.dispatcher', 'qcAgent'])
            ->latest()
            ->take(5)
            ->get();

        return view('qc.dashboard', compact('stats', 'recentReviews'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dispatcherId = $request->query('dispatcher_id');
        
        // Fetch all dispatchers for the filter sidebar
        $dispatchers = \App\Models\Dispatcher::withCount('calls')->get();

        // Fetch calls with dispatcher and score (if any)
        $query = Call::with(['dispatcher', 'qcScore']);

        if ($dispatcherId) {
            $query->where('dispatcher_id', $dispatcherId);
        }

        $calls = $query->latest()->paginate(20)->withQueryString();

        $selectedDispatcher = $dispatcherId ? $dispatchers->firstWhere('id', $dispatcherId) : null;

        return view('qc.index', compact('calls', 'dispatchers', 'selectedDispatcher'));
    }

    /**
     * Sync calls from OpenPhone.
     */
    public function sync()
    {
        Artisan::queue('calls:import');
        
        return back()->with('success', 'Calls synced successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Call $call)
    {
        $call->load(['dispatcher', 'qcScore']);
        
        return view('qc.show', compact('call'));
    }

    /**
     * Store or update a QC score for a call.
     */
    public function storeScore(Request $request, Call $call)
    {
        // Check if locked
        if ($call->qcScore && $call->qcScore->is_locked) {
            return back()->with('error', 'This score is locked and cannot be modified.');
        }

        $validated = $request->validate([
            'communication_score' => 'required|integer|min:1|max:5',
            'confidence_score' => 'required|integer|min:1|max:5',
            'professionalism_score' => 'required|integer|min:1|max:5',
            'closing_score' => 'required|integer|min:1|max:5',
            'remarks' => 'nullable|string|max:1000',
        ]);

        QcScore::updateOrCreate(
            ['call_id' => $call->id],
            [
                'qc_agent_id' => Auth::id(),
                'communication_score' => $validated['communication_score'],
                'confidence_score' => $validated['confidence_score'],
                'professionalism_score' => $validated['professionalism_score'],
                'closing_score' => $validated['closing_score'],
                'remarks' => $validated['remarks'],
            ]
        );

        return redirect()->route('qc.calls.index')->with('success', 'Score submitted successfully.');
    }
}
