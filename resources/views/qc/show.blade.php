<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('qc.calls.index') }}" class="p-2 hover:bg-gray-800 rounded-full transition-colors text-gray-400 print:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h2 class="font-bold text-2xl text-white leading-tight">
                    Review <span class="text-indigo-theme">Interaction</span>
                </h2>
            </div>
            <div class="print:hidden">
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg font-bold text-xs text-gray-300 uppercase tracking-widest shadow-lg hover:bg-gray-700 transition duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print Report
                </button>
            </div>
        </div>
    </x-slot>

    <!-- Print Only Header -->
    <div class="hidden print:block mb-8 text-center border-b-2 border-gray-900 pb-4">
        <h2 class="text-2xl font-bold uppercase tracking-widest">Call Quality Performance Report</h2>
        <p class="text-sm mt-1">Generated: {{ now()->format('F d, Y - h:i A') }}</p>
    </div>

    <div class="py-12 bg-[#111827] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Call Context & Audio -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Audio Player Card -->
                    <div class="bg-[#1f2937]/90 backdrop-blur-sm rounded-3xl shadow-2xl shadow-black/50 border border-gray-800 overflow-hidden">
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-8">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-indigo-theme rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-500/20 mr-4">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-100">Call Recording</h3>
                                        <p class="text-sm text-gray-500">Listen to the full interaction for accurate scoring.</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Duration</span>
                                    <p class="text-lg font-bold text-indigo-theme">{{ gmdate("i:s", $call->duration) }}</p>
                                </div>
                            </div>

                            @if($call->recording_url)
                                <div class="bg-[#111827] rounded-2xl p-6 border border-gray-800">
                                    <audio controls class="w-full custom-audio">
                                        <source src="{{ $call->recording_url }}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            @else
                                <div class="bg-rose-50 rounded-2xl p-8 border border-rose-100 text-center">
                                    <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </div>
                                    <p class="text-rose-600 font-bold italic">Audio recording is unavailable for this call.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="bg-[#1f2937]/90 backdrop-blur-sm rounded-3xl shadow-2xl shadow-black/50 border border-gray-800 p-8">
                        <h3 class="text-lg font-bold text-gray-100 mb-6">Interaction Context</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                            <div class="flex items-start">
                                <div class="p-3 bg-blue-500/10 text-blue-400 rounded-xl mr-4 border border-blue-500/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div>
                                    <dt class="text-xs font-bold text-gray-500 uppercase tracking-widest">Dispatcher</dt>
                                    <dd class="text-sm font-bold text-gray-100 mt-1">{{ $call->dispatcher->name ?? 'Unknown' }}</dd>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="p-3 bg-purple-500/10 text-purple-400 rounded-xl mr-4 border border-purple-500/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <dt class="text-xs font-bold text-gray-500 uppercase tracking-widest">Date & Time</dt>
                                    <dd class="text-sm font-bold text-gray-100 mt-1">{{ $call->called_at->format('M d, Y') }} at {{ $call->called_at->format('h:i A') }}</dd>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="p-3 bg-amber-500/10 text-amber-400 rounded-xl mr-4 border border-amber-500/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </div>
                                <div>
                                    <dt class="text-xs font-bold text-gray-500 uppercase tracking-widest">Direction</dt>
                                    <dd class="text-sm font-bold text-gray-100 mt-1 capitalize">{{ $call->direction }} Flow</dd>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="p-3 bg-emerald-500/10 text-emerald-400 rounded-xl mr-4 border border-emerald-500/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                <div>
                                    <dt class="text-xs font-bold text-gray-500 uppercase tracking-widest">System Status</dt>
                                    <dd class="text-sm font-bold text-gray-100 mt-1">Verified & Secure</dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- AI Summary Card -->
                    <div class="bg-[#1f2937]/90 backdrop-blur-sm rounded-3xl shadow-2xl shadow-black/50 border border-gray-800 p-8">
                        <div class="flex items-center mb-6">
                            <div class="p-3 bg-indigo-500/10 text-indigo-400 rounded-xl mr-4 border border-indigo-500/20 shadow-[0_0_15px_rgba(79,70,229,0.1)]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-100 italic">AI Transcription Summary</h3>
                                <p class="text-xs text-gray-500 uppercase tracking-widest mt-0.5">Automated Insights</p>
                            </div>
                        </div>
                        <div class="bg-gray-900/50 rounded-2xl p-6 border border-gray-800 group transition-all duration-300 hover:border-indigo-500/30">
                            @if($call->summary)
                                <p class="text-gray-300 leading-relaxed text-sm italic">
                                    "{{ $call->summary }}"
                                </p>
                            @else
                                <div class="flex flex-col items-center py-4 text-center">
                                    <svg class="w-10 h-10 text-gray-700 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-gray-500 text-xs font-medium">No AI summary available for this interaction yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- AI Transcript Card -->
                    <div class="bg-[#1f2937]/90 backdrop-blur-sm rounded-3xl shadow-2xl shadow-black/50 border border-gray-800 p-8">
                        <div class="flex items-center mb-6">
                            <div class="p-3 bg-fuchsia-500/10 text-fuchsia-400 rounded-xl mr-4 border border-fuchsia-500/20 shadow-[0_0_15px_rgba(217,70,239,0.1)]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-100 italic">Call Transcript</h3>
                                <p class="text-xs text-gray-500 uppercase tracking-widest mt-0.5">Full Conversation</p>
                            </div>
                        </div>
                        <div class="bg-gray-900/50 rounded-2xl border border-gray-800 max-h-[400px] overflow-y-auto custom-scrollbar group transition-all duration-300 hover:border-fuchsia-500/30">
                            @if($call->transcript)
                                <div class="p-6">
                                    <pre class="whitespace-pre-wrap text-gray-400 text-sm leading-relaxed font-sans">{{ $call->transcript }}</pre>
                                </div>
                            @else
                                <div class="flex flex-col items-center py-8 text-center">
                                    <svg class="w-10 h-10 text-gray-700 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-gray-500 text-xs font-medium">Transcript is not available for this interaction.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Scoring Sidebar -->
                <div class="space-y-8">
                    <div class="bg-[#1f2937]/90 backdrop-blur-sm rounded-3xl shadow-2xl shadow-black/50 border border-gray-800 p-8 overflow-hidden relative">
                        <!-- Decorative glow -->
                        <div class="absolute -top-16 -right-16 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl opacity-50"></div>
                        
                        <h3 class="text-xl font-bold text-gray-100 mb-6 relative">Quality ScoreCard</h3>
                        
                        @if(session('error'))
                            <div class="bg-rose-50 text-rose-600 text-sm p-3 rounded-xl mb-6 font-medium animate-fade-in flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('qc.calls.store_score', $call) }}" method="POST" class="space-y-6 relative">
                            @csrf
                            
                            @php
                                $score = $call->qcScore;
                                $isLocked = $score && $score->is_locked;
                            @endphp

                            <!-- Scoring Categories -->
                            @foreach([
                                'communication' => 'Communication',
                                'confidence' => 'Confidence',
                                'professionalism' => 'Professionalism',
                                'closing' => 'Closing'
                            ] as $key => $label)
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">{{ $label }} (1-5)</label>
                                <div class="relative group">
                                    <input type="range" name="{{ $key }}_score" min="1" max="5" step="1" 
                                           value="{{ old($key.'_score', $score->{$key.'_score'} ?? 4) }}" 
                                           class="w-full h-2 bg-gray-800 rounded-lg appearance-none cursor-pointer accent-indigo-600"
                                           {{ $isLocked ? 'disabled' : '' }} required
                                           oninput="this.nextElementSibling.innerText = this.value">
                                    <span class="absolute -top-8 right-0 text-lg font-black text-indigo-400 bg-gray-800 w-8 h-8 flex items-center justify-center rounded-lg shadow-sm border border-gray-700">
                                        {{ old($key.'_score', $score->{$key.'_score'} ?? 4) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Remarks</label>
                                <textarea name="remarks" rows="3" 
                                          class="w-full rounded-2xl border-gray-800 bg-gray-900 focus:border-indigo-500 focus:ring-indigo-500 text-sm p-4 placeholder-gray-600 text-gray-300 transition-all duration-200"
                                          placeholder="Share specific feedback..."
                                          {{ $isLocked ? 'disabled' : '' }}>{{ old('remarks', $score->remarks ?? '') }}</textarea>
                            </div>

                            @if(!$isLocked)
                            <div class="pt-4">
                                <button type="submit" class="w-full btn-finalize text-white rounded-2xl py-4 font-bold shadow-lg shadow-indigo-500/20 transition-all duration-200 active:translate-y-0">
                                    Finalize Review
                                </button>
                            </div>
                            @else
                            <div class="pt-4 bg-gray-900/50 rounded-2xl p-4 text-center border border-gray-800">
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Interaction Locked</span>
                                <p class="text-sm text-gray-400 mt-1 italic">This review has been finalized and is currently immutable.</p>
                            </div>
                            @endif
                        </form>
                    </div>

                    <!-- Avg Score Preview -->
                    @if($score)
                    <div class="bg-indigo-600 rounded-3xl p-8 text-white relative overflow-hidden shadow-2xl shadow-indigo-900/50">
                        <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                        <h4 class="text-sm font-bold uppercase tracking-widest text-indigo-100 mb-2">Resulting Score</h4>
                        @php
                            $avg = ($score->communication_score + $score->confidence_score + $score->professionalism_score + $score->closing_score) / 4;
                        @endphp
                        <div class="flex items-baseline">
                            <span class="text-5xl font-black">{{ number_format($avg, 1) }}</span>
                            <span class="text-lg text-white/70 ml-2 font-bold">/ 5.0</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --indigo-primary: #4f46e5;
            --indigo-hover: #4338ca;
            --score-card-bg: #312e81;
        }

        @media print {
            body, .bg-[#111827] {
                background-color: white !important;
                color: black !important;
            }
            
            .py-12 { padding-top: 0 !important; padding-bottom: 0 !important; }
            
            /* Hide non-printable components */
            .print\:hidden,
            .bg-[#1f2937] .p-8:has(audio),
            .bg-[#1f2937] .flex:has(audio),
            audio,
            .btn-finalize,
            .shadow-2xl,
            .shadow-black\/50,
            form button,
            .absolute {
                display: none !important;
            }

            /* Un-darken cards for printing */
            .bg-\[\#1f2937\]\/90, .bg-\[\#1f2937\] {
                background-color: white !important;
                border: 1px solid #eee !important;
                backdrop-filter: none !important;
                color: black !important;
                box-shadow: none !important;
            }

            .text-white, .text-gray-100, .text-gray-200, .text-gray-300, .text-gray-400 {
                color: black !important;
            }

            .text-indigo-theme, .text-amber-400, .text-emerald-400 {
                color: #312e81 !important; /* Professional dark blue for print */
            }

            /* Adjust grid for print */
            .grid {
                display: block !important;
            }
            
            .lg\:col-span-2, .space-y-8 {
                width: 100% !important;
            }

            /* Fix range sliders for print */
            input[type='range'] {
                display: none !important;
            }
            
            /* Ensure the numeric scores are visible */
            .relative.group span.absolute {
                position: relative !important;
                top: 0 !important;
                right: 0 !important;
                background: none !important;
                border: none !important;
                display: block !important;
                font-size: 1.2rem !important;
                font-weight: bold !important;
            }

            .rounded-3xl { border-radius: 8px !important; }
            
            /* Keep remarks box clear */
            textarea {
                border: 1px solid #ccc !important;
                background: white !important;
                color: black !important;
            }

            /* Summary score card */
            .bg-indigo-600 {
                background: #f3f4f6 !important;
                border: 2px solid #312e81 !important;
                color: #312e81 !important;
            }
            .text-indigo-100, .text-white\/70 { color: #666 !important; }
        }

        .text-indigo-theme { color: var(--indigo-primary); }
        .bg-indigo-theme { background-color: var(--indigo-primary) !important; }
        .bg-score-card { background-color: var(--score-card-bg) !important; }
        .btn-finalize {
            background-color: var(--indigo-primary) !important;
            transition: all 0.2s;
        }
        .btn-finalize:hover {
            background-color: var(--indigo-hover) !important;
            transform: translateY(-1px);
        }
        .custom-audio {
            height: 44px;
        }
        .custom-audio::-webkit-media-controls-enclosure {
            border-radius: 12px;
            background-color: #1f2937;
        }
        input[type='range'] {
            accent-color: var(--indigo-primary);
        }
        input[type='range']::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            background: var(--indigo-primary);
            border-radius: 50%;
            cursor: pointer;
            border: 3px solid white;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #111827;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #374151;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #4b5563;
        }
    </style>
</x-app-layout>
