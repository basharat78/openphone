<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">
                {{ __('Quality Control') }} <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Dashboard</span>
            </h2>
            <div class="flex items-center space-x-4">
                <form action="{{ route('qc.calls.sync') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-bold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Fetch Calls
                    </button>
                </form>
                
                <div class="flex items-center space-x-2 text-sm text-gray-500 border-l pl-4 border-gray-300 py-1">
                    <span class="flex h-2 w-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                    <span class="font-medium hidden sm:inline">Live Sync</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#111827] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar: Dispatcher Selection -->
                <div class="w-full lg:w-1/4">
                    <div class="bg-[#1f2937]/90 backdrop-blur-sm border border-gray-800 shadow-2xl shadow-black/50 rounded-3xl overflow-hidden sticky top-8">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6">
                            <h3 class="text-sm font-black text-white uppercase tracking-widest mb-1">Dispatchers</h3>
                            <p class="text-indigo-100 text-xs">Select to filter calls</p>
                        </div>
                        <div class="p-6">
                            <div class="space-y-2 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                                <a href="{{ route('qc.calls.index') }}" 
                                   class="group flex items-center justify-between px-4 py-3.5 rounded-xl transition-all duration-200 {{ !$selectedDispatcher ? 'active-item text-white shadow-lg' : 'text-gray-400 hover:bg-gradient-to-r hover:from-gray-800 hover:to-gray-700 hover:text-indigo-400' }}">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-xl {{ !$selectedDispatcher ? 'bg-white/20' : 'bg-gradient-to-br from-indigo-400 to-purple-400' }} flex items-center justify-center mr-3 shadow-md">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </div>
                                        <span class="font-bold">All Systems</span>
                                    </div>
                                    @if(!$selectedDispatcher)
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                    @endif
                                </a>

                                @foreach($dispatchers as $dispatcher)
                                <a href="{{ route('qc.calls.index', ['dispatcher_id' => $dispatcher->id]) }}" 
                                   class="group flex items-center justify-between px-4 py-3.5 rounded-xl transition-all duration-200 {{ $selectedDispatcher && $selectedDispatcher->id == $dispatcher->id ? 'active-item text-white shadow-lg' : 'text-gray-400 hover:bg-gradient-to-r hover:from-gray-800 hover:to-gray-700 hover:text-indigo-400' }}">
                                    <div class="flex items-center overflow-hidden">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3 text-xs font-black shadow-md {{ $selectedDispatcher && $selectedDispatcher->id == $dispatcher->id ? 'bg-white/20 text-white' : 'bg-gradient-to-br from-blue-500 to-cyan-600 text-white' }}">
                                            {{ substr($dispatcher->name, 0, 1) }}
                                        </div>
                                        <span class="font-semibold truncate">{{ $dispatcher->name }}</span>
                                    </div>
                                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-lg {{ $selectedDispatcher && $selectedDispatcher->id == $dispatcher->id ? 'bg-white/20 text-white' : 'bg-gray-800 text-indigo-400' }}">
                                        {{ $dispatcher->calls_count }}
                                    </span>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content: Call List -->
                <div class="w-full lg:w-3/4">
                    <div class="bg-[#1f2937]/90 backdrop-blur-sm border border-gray-800 shadow-2xl shadow-black/50 rounded-3xl overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-800 via-gray-900 to-black p-8 border-b border-gray-800">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                <div>
                                    <h3 class="text-2xl font-black text-white tracking-tight">
                                        {{ $selectedDispatcher ? "History for {$selectedDispatcher->name}" : "Recent Call History" }}
                                    </h3>
                                    <p class="text-purple-100 text-sm font-medium mt-1">Review and score recent interactions for quality assurance.</p>
                                </div>
                                @if($selectedDispatcher)
                                    <a href="{{ route('qc.calls.index') }}" class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm text-white hover:bg-white/30 rounded-xl transition-colors text-xs font-bold border border-white/30">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Clear Filter
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="p-8">
                            @if(session('success'))
                                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-xl mb-8 flex items-center animate-fade-in shadow-md">
                                    <svg class="w-5 h-5 mr-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    <span class="font-bold">{{ session('success') }}</span>
                                </div>
                            @endif

                            <div class="overflow-x-auto -mx-8">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-gray-800/50 border-y border-gray-700">
                                            <th class="px-8 py-5 text-[11px] font-black text-gray-400 uppercase tracking-widest">Time & Date</th>
                                            @if(!$selectedDispatcher)
                                                <th class="px-8 py-5 text-[11px] font-black text-gray-400 uppercase tracking-widest">Dispatcher</th>
                                            @endif
                                            <th class="px-8 py-5 text-[11px] font-black text-gray-400 uppercase tracking-widest text-center">Recording</th>
                                            <th class="px-8 py-5 text-[11px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                                            <th class="px-8 py-5 text-[11px] font-black text-gray-400 uppercase tracking-widest text-right">Review</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-800">
                                        @forelse($calls as $call)
                                        <tr class="hover:bg-gray-800/50 transition-colors group">
                                            <td class="px-8 py-6">
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-black text-gray-100">{{ $call->called_at->format('h:i A') }}</span>
                                                    <span class="text-[11px] font-bold text-gray-500 uppercase">{{ $call->called_at->format('M d, Y') }}</span>
                                                </div>
                                            </td>
                                            @if(!$selectedDispatcher)
                                                <td class="px-8 py-6">
                                                    @if($call->dispatcher)
                                                        <a href="{{ route('qc.calls.index', ['dispatcher_id' => $call->dispatcher_id]) }}" class="inline-flex items-center group/name">
                                                            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 text-white flex items-center justify-center text-[10px] font-black mr-2 group-hover/name:shadow-lg transition-all">
                                                                {{ substr($call->dispatcher->name, 0, 1) }}
                                                            </div>
                                                            <span class="text-sm font-bold text-gray-300 group-hover/name:text-indigo-400 transition-colors">
                                                                {{ $call->dispatcher->name }}
                                                            </span>
                                                        </a>
                                                    @else
                                                        <span class="text-sm text-gray-300 italic font-medium">Unassigned</span>
                                                    @endif
                                                </td>
                                            @endif
                                            <td class="px-8 py-6 text-center">
                                                @if($call->recording_url)
                                                    <div class="inline-flex items-center bg-blue-500/10 text-blue-400 border border-blue-500/20 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-tighter shadow-md">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                                                        Captured
                                                    </div>
                                                @else
                                                    <span class="text-[10px] font-bold text-gray-600 uppercase">No Audio</span>
                                                @endif
                                            </td>
                                            <td class="px-8 py-6">
                                                @if($call->qcScore)
                                                    <div class="flex items-center">
                                                        <div class="w-2 h-2 rounded-full bg-emerald-500 mr-2 shadow-[0_0_8px_rgba(16,185,129,0.6)]"></div>
                                                        <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Completed</span>
                                                    </div>
                                                @else
                                                    <div class="flex items-center">
                                                        <div class="w-2 h-2 rounded-full bg-amber-400 mr-2 animate-pulse shadow-[0_0_8px_rgba(251,191,36,0.6)]"></div>
                                                        <span class="text-[10px] font-black text-amber-400/80 uppercase tracking-widest">Waiting Review</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-8 py-6 text-right">
                                                <a href="{{ route('qc.calls.show', $call) }}" 
                                                   class="inline-flex items-center px-5 py-2.5 rounded-xl text-xs font-black transition-all duration-200 shadow-lg {{ $call->qcScore ? 'view-btn text-emerald-400' : 'review-btn text-white' }}">
                                                    {{ $call->qcScore ? 'View Score' : 'Start Review' }}
                                                    <svg class="w-3.5 h-3.5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="px-8 py-20 text-center">
                                                <div class="flex flex-col items-center">
                                                    <div class="w-20 h-20 bg-gray-800 rounded-3xl flex items-center justify-center mb-4 shadow-lg">
                                                        <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                                                    </div>
                                                    <h4 class="text-lg font-black text-gray-500 tracking-tight">Quiet on the front lines...</h4>
                                                    <p class="text-gray-600 text-xs mt-1 font-medium">No call records found for this selection.</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-8 border-t border-gray-800 pt-8">
                                {{ $calls->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .active-item { 
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important;
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4);
        }
        .review-btn { 
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%) !important;
        }
        .review-btn:hover { 
            background: linear-gradient(135deg, #4338ca 0%, #4f46e5 100%) !important;
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(79, 70, 229, 0.5);
        }
        .view-btn {
            background: rgba(16, 185, 129, 0.1) !important;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        .view-btn:hover {
            background: rgba(16, 185, 129, 0.2) !important;
            transform: translateY(-2px);
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #a855f7, #6366f1);
            border-radius: 10px;
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-app-layout>
