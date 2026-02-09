<?php

namespace App\Http\Controllers\Qc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class QcController extends Controller
{

    public function index(Request $request)
    {
        // Dummy dispatchers
        $dispatchers = collect([
            (object)['id'=>1,'name'=>'John Smith','calls_count'=>4],
            (object)['id'=>2,'name'=>'Sarah Lee','calls_count'=>3],
            (object)['id'=>3,'name'=>'Michael Ray','calls_count'=>2],
        ]);

        // Selected dispatcher
        $selectedDispatcher = $dispatchers
            ->firstWhere('id', $request->dispatcher_id) ?? null;

        // Dummy calls
        $calls = collect([
            (object)[
                'id'=>1,
                'called_at'=>Carbon::now()->subMinutes(10),
                'recording_url'=>'audio.mp3',
                'qcScore'=>true,
                'dispatcher'=>(object)['name'=>'John Smith']
            ],
            (object)[
                'id'=>2,
                'called_at'=>Carbon::now()->subHour(),
                'recording_url'=>null,
                'qcScore'=>false,
                'dispatcher'=>(object)['name'=>'Sarah Lee']
            ],
        ]);

        // Fake pagination
        $calls = new LengthAwarePaginator(
            $calls,
            $calls->count(),
            5
        );

        return view('qc.index', compact(
            'dispatchers',
            'selectedDispatcher',
            'calls'
        ));
    }

}
