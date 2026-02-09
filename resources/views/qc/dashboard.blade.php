<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">
                {{ __('QC') }} <span class="bg-gradient-to-r from-indigo-500 to-purple-500 bg-clip-text text-transparent">Analytics Dashboard</span>
            </h2>
            <div class="flex items-center space-x-4">
                <div class="print:hidden flex items-center space-x-2">
                    <form action="{{ route('qc.calls.sync') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg font-bold text-xs text-indigo-400 uppercase tracking-widest shadow-lg hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Sync
                        </button>
                    </form>
                    <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg font-bold text-xs text-gray-300 uppercase tracking-widest shadow-lg hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Print
                    </button>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Print Only Header -->
    <div class="hidden print:block mb-8 text-center border-b-2 border-gray-900 pb-4">
        <h2 class="text-2xl font-bold uppercase tracking-widest">QC Specialist Performance Analytics</h2>
        <p class="text-sm mt-1">Report Generated: {{ now()->format('F d, Y - h:i A') }}</p>
    </div>

    <div class="py-12 bg-[#111827] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Calls -->
                <div class="bg-[#1f2937]/90 backdrop-blur-sm border border-gray-800 p-8 rounded-3xl shadow-2xl relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-110 transition-transform text-white">
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <dt class="text-xs font-black text-gray-500 uppercase tracking-widest mb-1">Total Calls</dt>
                    <dd class="flex items-baseline">
                        <span class="text-4xl font-black text-white">{{ number_format($stats['total_calls']) }}</span>
                        <span class="ml-2 text-xs font-bold text-gray-400">Captured</span>
                    </dd>
                </div>

                <!-- Reviewed -->
                <div class="bg-[#1f2937]/90 backdrop-blur-sm border border-gray-800 p-8 rounded-3xl shadow-2xl relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-110 transition-transform text-white">
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <dt class="text-xs font-black text-gray-500 uppercase tracking-widest mb-1">Reviewed</dt>
                    <dd class="flex items-baseline">
                        <span class="text-4xl font-black text-emerald-400">{{ number_format($stats['reviewed_calls']) }}</span>
                        <span class="ml-2 text-xs font-bold text-gray-400">Sessions</span>
                    </dd>
                </div>

                <!-- Pending -->
                <div class="bg-[#1f2937]/90 backdrop-blur-sm border border-gray-800 p-8 rounded-3xl shadow-2xl relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-110 transition-transform text-white">
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <dt class="text-xs font-black text-gray-500 uppercase tracking-widest mb-1">Pending</dt>
                    <dd class="flex items-baseline">
                        <span class="text-4xl font-black text-amber-400">{{ number_format($stats['pending_calls']) }}</span>
                        <span class="ml-2 text-xs font-bold text-gray-400">Waiting</span>
                    </dd>
                </div>

                <!-- Avg Quality -->
                <div class="bg-gradient-to-br from-indigo-600 to-purple-700 p-8 rounded-3xl shadow-2xl relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform text-white text-opacity-30">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    </div>
                    <dt class="text-xs font-black text-indigo-100 uppercase tracking-widest mb-1">Quality Score</dt>
                    <dd class="flex items-baseline">
                        <span class="text-4xl font-black text-white">{{ number_format($stats['avg_score'], 1) }}</span>
                        <span class="ml-2 text-xs font-bold text-indigo-200">/ 5.0</span>
                    </dd>
                </div>
            </div>

            <!-- Recent Reviews & Trends -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Reviews Table -->
                <div class="lg:col-span-2">
                    <div class="bg-[#1f2937]/90 backdrop-blur-sm border border-gray-800 shadow-2xl rounded-3xl overflow-hidden">
                        <div class="p-8 border-b border-gray-800 bg-gray-900/50 flex items-center justify-between">
                            <h3 class="text-lg font-black text-white tracking-tight leading-none">Recent <span class="text-indigo-400">Reviews</span></h3>
                            <a href="{{ route('qc.calls.index') }}" class="text-xs font-bold text-indigo-400 hover:text-indigo-300 transition-colors uppercase tracking-widest">View All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="bg-gray-800/30">
                                        <th class="px-8 py-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">Interaction</th>
                                        <th class="px-8 py-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">Agent</th>
                                        <th class="px-8 py-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">Score</th>
                                        <th class="px-8 py-4 text-[10px] font-black text-gray-500 uppercase tracking-widest text-right">Details</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-800">
                                    @forelse($recentReviews as $review)
                                    <tr class="hover:bg-gray-800/50 transition-colors group">
                                        <td class="px-8 py-5">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center mr-3 text-indigo-400 font-black text-[10px] border border-indigo-500/20">
                                                    {{ substr($review->call->dispatcher->name ?? '?', 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-gray-200">{{ $review->call->dispatcher->name ?? 'Unknown' }}</div>
                                                    <div class="text-[10px] font-medium text-gray-500">{{ $review->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5">
                                            <div class="text-sm font-bold text-gray-400">{{ $review->qcAgent->name }}</div>
                                        </td>
                                        <td class="px-8 py-5">
                                            @php
                                                $avg = ($review->communication_score + $review->confidence_score + $review->professionalism_score + $review->closing_score) / 4;
                                            @endphp
                                            <div class="flex items-center">
                                                <span class="text-sm font-black {{ $avg >= 4 ? 'text-emerald-400' : ($avg >= 3 ? 'text-amber-400' : 'text-rose-400') }}">
                                                    {{ number_format($avg, 1) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            <a href="{{ route('qc.calls.show', $review->call_id) }}" class="p-2 bg-gray-800 hover:bg-gray-700 rounded-lg text-gray-400 hover:text-white transition-all inline-flex">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-12 text-center text-gray-600 italic text-sm">No reviews yet. Start checking calls!</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Secondary Column -->
                <div class="space-y-8">
                    <!-- Quick Actions -->
                    <div class="bg-[#1f2937]/90 backdrop-blur-sm border border-gray-800 shadow-2xl rounded-3xl p-8">
                        <h3 class="text-lg font-black text-white tracking-tight mb-6">Quick <span class="text-indigo-400">Actions</span></h3>
                        <div class="space-y-4">
                            <a href="{{ route('qc.calls.index') }}" class="flex items-center p-4 bg-gray-800 hover:bg-indigo-600 group rounded-2xl transition-all border border-gray-700 hover:border-indigo-500">
                                <div class="w-10 h-10 rounded-xl bg-gray-900 group-hover:bg-white/20 flex items-center justify-center mr-4 transition-colors">
                                    <svg class="w-5 h-5 text-indigo-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-200 group-hover:text-white">Start Checking</div>
                                    <div class="text-xs text-gray-500 group-hover:text-indigo-100">Review new call sessions</div>
                                </div>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center p-4 bg-gray-800 hover:bg-gray-700 group rounded-2xl transition-all border border-gray-700">
                                <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-200">User Profile</div>
                                    <div class="text-xs text-gray-500">Manage your settings</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Performance Tip -->
                    <div class="bg-indigo-600/10 border border-indigo-500/20 p-8 rounded-3xl relative overflow-hidden group">
                        <div class="relative z-10">
                            <div class="text-indigo-400 mb-2">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            </div>
                            <h4 class="text-md font-black text-indigo-300 mb-2 tracking-tight">Focus on Confidence</h4>
                            <p class="text-sm text-gray-400 leading-relaxed font-medium">Recent data suggests that <span class="text-indigo-400">confidence</span> is the highest variant in score results this week.</p>
                        </div>
                        <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        @media print {
            body, .bg-\[\#111827\] {
                background-color: white !important;
                color: black !important;
            }
            .py-12 { padding-top: 0 !important; }

            /* Hide interactive elements */
            .print\:hidden, 
            .bg-gradient-to-br i,
            .bg-gradient-to-br svg,
            .absolute {
                display: none !important;
            }

            /* Un-darken cards */
            .bg-\[\#1f2937\]\/90, .bg-\[\#1f2937\], .bg-gray-900\/50, .bg-gray-800\/30 {
                background-color: white !important;
                border: 1px solid #ddd !important;
                color: black !important;
                backdrop-filter: none !important;
                box-shadow: none !important;
            }

            .bg-gradient-to-br.from-indigo-600 {
                background: #f3f4f6 !important;
                border: 2px solid #4f46e5 !important;
                color: #4f46e5 !important;
            }

            .text-white, .text-gray-100, .text-gray-200, .text-gray-400, .text-gray-500 {
                color: black !important;
            }

            .text-indigo-400, .text-emerald-400, .text-amber-400 {
                color: #4f46e5 !important;
            }

            .divide-gray-800 { divide-color: #eee !important; }
            
            /* Responsive grid fix for print */
            .grid { display: block !important; }
            .grid > div { margin-bottom: 20px !important; break-inside: avoid; }
            
            table { width: 100% !important; border-collapse: collapse !important; }
            th, td { border: 1px solid #eee !important; padding: 10px !important; }

            .rounded-3xl, .rounded-2xl { border-radius: 8px !important; }
        }
    </style>
</x-app-layout>
