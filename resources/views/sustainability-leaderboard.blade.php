@extends('layouts.master')

@section('title', 'Sustainability Leaderboard - UBarter 2.0')

@section('content')
<style>
    .rank-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        font-weight: bold;
        font-size: 16px;
    }
    .rank-1 { background: linear-gradient(135deg, #f5c518 0%, #f5d658 100%); color: #7b0f10; }
    .rank-2 { background: linear-gradient(135deg, #c0c0c0 0%, #e8e8e8 100%); color: #333; }
    .rank-3 { background: linear-gradient(135deg, #cd7f32 0%, #d4a574 100%); color: white; }
    .progress-bar-container { background: #e5e7eb; border-radius: 999px; overflow: hidden; height: 5px; }
    .progress-bar { background: linear-gradient(90deg, #7b0f10 0%, #f5c518 100%); height: 100%; }
</style>

<div class="px-4 md:px-6 py-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-leaf mr-2.5 text-green-600"></i>Sustainability Leaderboard
                </h1>
                <p class="text-gray-500 text-sm mt-1">See who's making the biggest environmental impact through UBarter!</p>
            </div>
            <div class="flex gap-2">
                <button class="px-4 py-2 rounded-lg text-sm font-bold border-2 border-[#7b0f10] text-[#7b0f10] hover:bg-[#7b0f10] hover:text-white transition">
                    <i class="fas fa-calendar mr-1.5"></i> This Week
                </button>
                <button class="px-4 py-2 rounded-lg text-sm font-bold border-2 border-gray-200 text-gray-600 hover:border-[#7b0f10] transition">
                    <i class="fas fa-calendar-alt mr-1.5"></i> All Time
                </button>
            </div>
        </div>
    </div>

    <!-- Leaderboard Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl p-4 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-widest opacity-80">Total Waste Diverted</p>
            <p class="text-3xl font-bold mt-1.5">2,847 kg</p>
            <p class="text-xs mt-1 opacity-90">Since UBarter Launch</p>
        </div>

        <div class="bg-white rounded-xl p-4 border-l-4 border-[#f5c518] shadow-sm">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Active Participants</p>
            <p class="text-3xl font-bold text-[#7b0f10] mt-1.5">342</p>
            <p class="text-xs text-gray-400 mt-1">Students trading items</p>
        </div>

        <div class="bg-white rounded-xl p-4 border-l-4 border-[#7b0f10] shadow-sm">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Trades Completed</p>
            <p class="text-3xl font-bold text-[#7b0f10] mt-1.5">891</p>
            <p class="text-xs text-gray-400 mt-1">Successful exchanges</p>
        </div>

        <div class="bg-white rounded-xl p-4 border-l-4 border-green-500 shadow-sm">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Your Ranking</p>
            <p class="text-3xl font-bold text-green-600 mt-1.5">#47</p>
            <p class="text-xs text-gray-400 mt-1">Keep trading to climb!</p>
        </div>
    </div>

    <!-- Main Leaderboard -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="px-5 py-4 bg-gradient-to-r from-[#7b0f10] to-[#5a0a0b] text-white">
            <h2 class="text-lg font-bold">Top Eco Warriors — This Week</h2>
            <p class="text-gray-300 text-xs mt-0.5">Ranked by kilograms of waste diverted from campus landfills</p>
        </div>

        <div class="divide-y divide-gray-50">
            <!-- Rank 1 -->
            <div class="px-5 py-4 flex items-center justify-between hover:bg-[#f5c518]/5 transition">
                <div class="flex items-center gap-4 flex-1">
                    <div class="rank-badge rank-1 flex-shrink-0">🥇</div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-0.5">
                            <h3 class="font-bold text-gray-900 text-sm">Alex Chen</h3>
                            <span class="text-xs bg-[#f5c518] text-[#7b0f10] px-2 py-0.5 rounded-full font-bold">ECE</span>
                        </div>
                        <p class="text-xs text-gray-500">Consistent donor · 12 trades this week</p>
                        <div class="mt-2 flex items-center gap-2">
                            <div class="progress-bar-container flex-1 max-w-xs"><div class="progress-bar" style="width: 100%"></div></div>
                            <span class="text-xs font-bold text-gray-500">28.5 kg</span>
                        </div>
                    </div>
                </div>
                <div class="text-right flex-shrink-0 ml-4">
                    <p class="text-lg font-bold text-green-600">+8.2 kg</p>
                    <p class="text-xs text-gray-400">vs last week</p>
                </div>
            </div>

            <!-- Rank 2 -->
            <div class="px-5 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                <div class="flex items-center gap-4 flex-1">
                    <div class="rank-badge rank-2 flex-shrink-0">🥈</div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-0.5">
                            <h3 class="font-bold text-gray-900 text-sm">Maria Santos</h3>
                            <span class="text-xs bg-[#7b0f10]/10 text-[#7b0f10] px-2 py-0.5 rounded-full font-bold">BSN</span>
                        </div>
                        <p class="text-xs text-gray-500">Organized group trades · 8 trades this week</p>
                        <div class="mt-2 flex items-center gap-2">
                            <div class="progress-bar-container flex-1 max-w-xs"><div class="progress-bar" style="width: 84%"></div></div>
                            <span class="text-xs font-bold text-gray-500">24.0 kg</span>
                        </div>
                    </div>
                </div>
                <div class="text-right flex-shrink-0 ml-4">
                    <p class="text-lg font-bold text-green-600">+5.1 kg</p>
                    <p class="text-xs text-gray-400">vs last week</p>
                </div>
            </div>

            <!-- Rank 3 -->
            <div class="px-5 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                <div class="flex items-center gap-4 flex-1">
                    <div class="rank-badge rank-3 flex-shrink-0">🥉</div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-0.5">
                            <h3 class="font-bold text-gray-900 text-sm">James Reyes</h3>
                            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-bold">IT</span>
                        </div>
                        <p class="text-xs text-gray-500">Tech enthusiast · 7 trades this week</p>
                        <div class="mt-2 flex items-center gap-2">
                            <div class="progress-bar-container flex-1 max-w-xs"><div class="progress-bar" style="width: 78%"></div></div>
                            <span class="text-xs font-bold text-gray-500">22.3 kg</span>
                        </div>
                    </div>
                </div>
                <div class="text-right flex-shrink-0 ml-4">
                    <p class="text-lg font-bold text-green-600">+3.9 kg</p>
                    <p class="text-xs text-gray-400">vs last week</p>
                </div>
            </div>

            <!-- Rank 4 -->
            <div class="px-5 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                <div class="flex items-center gap-4 flex-1">
                    <div class="rank-badge flex-shrink-0" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white;">4</div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-0.5">
                            <h3 class="font-bold text-gray-900 text-sm">Sofia Garcia</h3>
                            <span class="text-xs bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full font-bold">CAS</span>
                        </div>
                        <p class="text-xs text-gray-500">Active negotiator · 10 trades this week</p>
                        <div class="mt-2 flex items-center gap-2">
                            <div class="progress-bar-container flex-1 max-w-xs"><div class="progress-bar" style="width: 72%"></div></div>
                            <span class="text-xs font-bold text-gray-500">20.5 kg</span>
                        </div>
                    </div>
                </div>
                <div class="text-right flex-shrink-0 ml-4">
                    <p class="text-lg font-bold text-green-600">+2.8 kg</p>
                    <p class="text-xs text-gray-400">vs last week</p>
                </div>
            </div>

            <!-- Rank 5 -->
            <div class="px-5 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                <div class="flex items-center gap-4 flex-1">
                    <div class="rank-badge flex-shrink-0" style="background: linear-gradient(135deg, #8b5cf6, #6d28d9); color: white;">5</div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-0.5">
                            <h3 class="font-bold text-gray-900 text-sm">John Dela Cruz</h3>
                            <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-bold">ME</span>
                        </div>
                        <p class="text-xs text-gray-500">New trader · 5 trades this week</p>
                        <div class="mt-2 flex items-center gap-2">
                            <div class="progress-bar-container flex-1 max-w-xs"><div class="progress-bar" style="width: 65%"></div></div>
                            <span class="text-xs font-bold text-gray-500">18.6 kg</span>
                        </div>
                    </div>
                </div>
                <div class="text-right flex-shrink-0 ml-4">
                    <p class="text-lg font-bold text-green-600">+4.2 kg</p>
                    <p class="text-xs text-gray-400">vs last week</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Your Ranking Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2">
            <div class="bg-gradient-to-br from-[#f5c518]/10 to-[#7b0f10]/5 border-l-4 border-[#f5c518] rounded-xl p-5">
                <h2 class="text-base font-bold text-[#7b0f10] mb-4 flex items-center">
                    <i class="fas fa-user-circle mr-2"></i> Your Stats
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-2xl font-bold text-[#7b0f10]">#47</p>
                        <p class="text-xs text-gray-500 mt-0.5 font-semibold">Your Rank</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-green-600">14.5 kg</p>
                        <p class="text-xs text-gray-500 mt-0.5 font-semibold">Waste Diverted</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-[#f5c518]">12</p>
                        <p class="text-xs text-gray-500 mt-0.5 font-semibold">Items Traded</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-blue-600">4.9/5</p>
                        <p class="text-xs text-gray-500 mt-0.5 font-semibold">Trust Score</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Achievements -->
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-base font-bold text-[#7b0f10] mb-3 flex items-center">
                <i class="fas fa-trophy text-[#f5c518] mr-2"></i> Achievements
            </h3>
            <div class="space-y-2">
                @foreach([
                    ['🌱', 'First Trade', 'Unlocked', 'bg-[#f5c518]/10', false],
                    ['🌿', 'Eco Advocate', '10 trades completed', 'bg-green-100', false],
                    ['🏆', 'Eco Legend', '50 kg waste diverted', 'bg-gray-100', true],
                    ['👑', 'Hall of Fame', 'Top 10 ranking', 'bg-gray-100', true],
                ] as $ach)
                <div class="flex items-center gap-3 p-2.5 {{ $ach[3] }} rounded-lg {{ $ach[4] ? 'opacity-40' : '' }}">
                    <span class="text-xl">{{ $ach[0] }}</span>
                    <div>
                        <p class="font-bold text-xs text-gray-900">{{ $ach[1] }}</p>
                        <p class="text-xs text-gray-500">{{ $ach[2] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Tips Section -->
    <div class="mt-5 bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-5 border-l-4 border-green-500">
        <h3 class="text-sm font-bold text-gray-900 mb-3 flex items-center">
            <i class="fas fa-lightbulb text-green-600 mr-2"></i> How to Boost Your Impact
        </h3>
        <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-gray-600">
            <li class="flex items-start gap-2"><i class="fas fa-check text-green-600 mt-0.5 flex-shrink-0"></i><span>Post items you no longer need — help others and reduce waste!</span></li>
            <li class="flex items-start gap-2"><i class="fas fa-check text-green-600 mt-0.5 flex-shrink-0"></i><span>Complete trades weekly — consistency matters in the rankings</span></li>
            <li class="flex items-start gap-2"><i class="fas fa-check text-green-600 mt-0.5 flex-shrink-0"></i><span>Leave positive reviews — build trust with the community</span></li>
            <li class="flex items-start gap-2"><i class="fas fa-check text-green-600 mt-0.5 flex-shrink-0"></i><span>Organize group trades — bigger impact, more waste diverted</span></li>
        </ul>
    </div>
</div>

<script>
    // Simulate live leaderboard updates
    setInterval(() => {
        // In a real app, this would fetch updated data from the server
        // Update rank positions, waste diverted amounts, etc.
    }, 10000); // Update every 10 seconds
</script>
@endsection
