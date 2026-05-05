@extends('layouts.master')

@section('title', 'Sustainability Leaderboard - UBarter 2.0')

@section('content')
<style>
    :root {
        --ub-maroon: #7b0f10;
        --ub-maroon-dark: #5a0a0b;
        --ub-gold: #f5c518;
        --ub-gold-light: #fce8a6;
    }
    
    .ub-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }
    
    .ub-card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    }
    
    .rank-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        font-weight: bold;
        font-size: 18px;
    }
    
    .rank-1 { background: linear-gradient(135deg, var(--ub-gold) 0%, #f5d658 100%); color: var(--ub-maroon); }
    .rank-2 { background: linear-gradient(135deg, #c0c0c0 0%, #e8e8e8 100%); color: #333; }
    .rank-3 { background: linear-gradient(135deg, #cd7f32 0%, #d4a574 100%); color: white; }
    
    .progress-bar-container {
        background: #e5e7eb;
        border-radius: 999px;
        overflow: hidden;
        height: 6px;
    }
    
    .progress-bar {
        background: linear-gradient(90deg, var(--ub-maroon) 0%, var(--ub-gold) 100%);
        height: 100%;
        transition: width 0.3s ease;
    }
</style>

<div class="p-6 md:p-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-5xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-leaf text-green-600 mr-3"></i>Sustainability Leaderboard
                </h1>
                <p class="text-gray-600 text-lg">See who's making the biggest environmental impact through UBarter!</p>
            </div>
            <div class="flex gap-3">
                <button class="px-6 py-2.5 rounded-lg text-sm font-bold border-2 border-[#7b0f10] text-[#7b0f10] hover:bg-[#7b0f10] hover:text-white transition">
                    <i class="fas fa-calendar mr-2"></i> This Week
                </button>
                <button class="px-6 py-2.5 rounded-lg text-sm font-bold border-2 border-gray-300 text-gray-700 hover:border-[#7b0f10] transition">
                    <i class="fas fa-calendar-alt mr-2"></i> All Time
                </button>
            </div>
        </div>
    </div>

    <!-- Leaderboard Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="ub-card bg-gradient-to-br from-green-500 to-green-600 text-white p-6">
            <p class="text-sm font-bold uppercase tracking-widest opacity-80">Total Waste Diverted</p>
            <p class="text-4xl font-bold mt-2">2,847 kg</p>
            <p class="text-xs mt-2 opacity-90">Since UBarter Launch</p>
        </div>
        
        <div class="ub-card bg-white p-6 border-l-4 border-[#f5c518]">
            <p class="text-sm font-bold text-gray-600 uppercase tracking-widest">Active Participants</p>
            <p class="text-4xl font-bold text-[#7b0f10] mt-2">342</p>
            <p class="text-xs text-gray-600 mt-2">Students trading items</p>
        </div>
        
        <div class="ub-card bg-white p-6 border-l-4 border-[#7b0f10]">
            <p class="text-sm font-bold text-gray-600 uppercase tracking-widest">Trades Completed</p>
            <p class="text-4xl font-bold text-[#7b0f10] mt-2">891</p>
            <p class="text-xs text-gray-600 mt-2">Successful exchanges</p>
        </div>
        
        <div class="ub-card bg-white p-6 border-l-4 border-green-600">
            <p class="text-sm font-bold text-gray-600 uppercase tracking-widest">Your Ranking</p>
            <p class="text-4xl font-bold text-green-600 mt-2">#47</p>
            <p class="text-xs text-gray-600 mt-2">Keep trading to climb!</p>
        </div>
    </div>

    <!-- Main Leaderboard -->
    <div class="ub-card overflow-hidden mb-8">
        <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-[#7b0f10] to-[#5a0a0b] text-white">
            <h2 class="text-2xl font-bold">Top Eco Warriors - This Week</h2>
            <p class="text-gray-300 text-sm mt-1">Ranked by kilograms of waste diverted from campus landfills</p>
        </div>

        <div class="divide-y divide-gray-100">
            <!-- Rank 1 -->
            <div class="p-6 flex items-center justify-between hover:bg-[#f5c518]/5 transition group">
                <div class="flex items-center gap-4 flex-1">
                    <div class="rank-badge rank-1">🥇</div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-bold text-lg text-gray-900">Alex Chen</h3>
                            <span class="text-xs bg-[#f5c518] text-[#7b0f10] px-2 py-1 rounded-full font-bold">ECE</span>
                        </div>
                        <p class="text-sm text-gray-600">Consistent donor • 12 trades this week</p>
                        <div class="mt-3 flex items-center gap-2">
                            <div class="progress-bar-container flex-1 max-w-xs">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="text-xs font-bold text-gray-600">28.5 kg</span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-green-600">+8.2 kg</p>
                    <p class="text-xs text-gray-600 mt-1">vs last week</p>
                </div>
            </div>

            <!-- Rank 2 -->
            <div class="p-6 flex items-center justify-between hover:bg-gray-50 transition group">
                <div class="flex items-center gap-4 flex-1">
                    <div class="rank-badge rank-2">🥈</div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-bold text-lg text-gray-900">Maria Santos</h3>
                            <span class="text-xs bg-[#7b0f10]/10 text-[#7b0f10] px-2 py-1 rounded-full font-bold">BSN</span>
                        </div>
                        <p class="text-sm text-gray-600">Organized group trades • 8 trades this week</p>
                        <div class="mt-3 flex items-center gap-2">
                            <div class="progress-bar-container flex-1 max-w-xs">
                                <div class="progress-bar" style="width: 84%"></div>
                            </div>
                            <span class="text-xs font-bold text-gray-600">24.0 kg</span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-green-600">+5.1 kg</p>
                    <p class="text-xs text-gray-600 mt-1">vs last week</p>
                </div>
            </div>

            <!-- Rank 3 -->
            <div class="p-6 flex items-center justify-between hover:bg-gray-50 transition group">
                <div class="flex items-center gap-4 flex-1">
                    <div class="rank-badge rank-3">🥉</div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-bold text-lg text-gray-900">James Reyes</h3>
                            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-bold">IT</span>
                        </div>
                        <p class="text-sm text-gray-600">Tech enthusiast • 7 trades this week</p>
                        <div class="mt-3 flex items-center gap-2">
                            <div class="progress-bar-container flex-1 max-w-xs">
                                <div class="progress-bar" style="width: 78%"></div>
                            </div>
                            <span class="text-xs font-bold text-gray-600">22.3 kg</span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-green-600">+3.9 kg</p>
                    <p class="text-xs text-gray-600 mt-1">vs last week</p>
                </div>
            </div>

            <!-- Rank 4 -->
            <div class="p-6 flex items-center justify-between hover:bg-gray-50 transition group">
                <div class="flex items-center gap-4 flex-1">
                    <div class="rank-badge" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white;">4</div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-bold text-lg text-gray-900">Sofia Garcia</h3>
                            <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full font-bold">CAS</span>
                        </div>
                        <p class="text-sm text-gray-600">Active negotiator • 10 trades this week</p>
                        <div class="mt-3 flex items-center gap-2">
                            <div class="progress-bar-container flex-1 max-w-xs">
                                <div class="progress-bar" style="width: 72%"></div>
                            </div>
                            <span class="text-xs font-bold text-gray-600">20.5 kg</span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-green-600">+2.8 kg</p>
                    <p class="text-xs text-gray-600 mt-1">vs last week</p>
                </div>
            </div>

            <!-- Rank 5 -->
            <div class="p-6 flex items-center justify-between hover:bg-gray-50 transition group">
                <div class="flex items-center gap-4 flex-1">
                    <div class="rank-badge" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); color: white;">5</div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-bold text-lg text-gray-900">John Dela Cruz</h3>
                            <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full font-bold">ME</span>
                        </div>
                        <p class="text-sm text-gray-600">New trader • 5 trades this week</p>
                        <div class="mt-3 flex items-center gap-2">
                            <div class="progress-bar-container flex-1 max-w-xs">
                                <div class="progress-bar" style="width: 65%"></div>
                            </div>
                            <span class="text-xs font-bold text-gray-600">18.6 kg</span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-green-600">+4.2 kg</p>
                    <p class="text-xs text-gray-600 mt-1">vs last week</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Your Ranking Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="ub-card bg-gradient-to-br from-[#f5c518]/10 to-[#7b0f10]/5 border-l-4 border-[#f5c518] p-6">
                <h2 class="text-2xl font-bold text-[#7b0f10] mb-4">
                    <i class="fas fa-user-circle mr-2"></i> Your Stats
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-3xl font-bold text-[#7b0f10]">#47</p>
                        <p class="text-xs text-gray-600 mt-1 font-semibold">Your Rank</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-green-600">14.5 kg</p>
                        <p class="text-xs text-gray-600 mt-1 font-semibold">Total Waste Diverted</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-[#f5c518]">12</p>
                        <p class="text-xs text-gray-600 mt-1 font-semibold">Items Traded</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-blue-600">4.9/5.0</p>
                        <p class="text-xs text-gray-600 mt-1 font-semibold">Trust Score</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Achievements -->
        <div class="ub-card p-6">
            <h3 class="text-xl font-bold text-[#7b0f10] mb-4">
                <i class="fas fa-trophy text-[#f5c518] mr-2"></i> Achievements
            </h3>
            <div class="space-y-3">
                <div class="flex items-center gap-3 p-3 bg-[#f5c518]/10 rounded-lg">
                    <span class="text-2xl">🌱</span>
                    <div>
                        <p class="font-bold text-sm text-gray-900">First Trade</p>
                        <p class="text-xs text-gray-600">Unlocked</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-green-100 rounded-lg">
                    <span class="text-2xl">🌿</span>
                    <div>
                        <p class="font-bold text-sm text-gray-900">Eco Advocate</p>
                        <p class="text-xs text-gray-600">10 trades completed</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-gray-100 rounded-lg opacity-50">
                    <span class="text-2xl">🏆</span>
                    <div>
                        <p class="font-bold text-sm text-gray-900">Eco Legend</p>
                        <p class="text-xs text-gray-600">50 kg waste diverted</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 bg-gray-100 rounded-lg opacity-50">
                    <span class="text-2xl">👑</span>
                    <div>
                        <p class="font-bold text-sm text-gray-900">Hall of Fame</p>
                        <p class="text-xs text-gray-600">Top 10 ranking</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tips Section -->
    <div class="mt-8 ub-card bg-gradient-to-r from-green-50 to-blue-50 p-6 border-l-4 border-green-600">
        <h3 class="text-lg font-bold text-gray-900 mb-3">
            <i class="fas fa-lightbulb text-green-600 mr-2"></i> How to Boost Your Impact
        </h3>
        <ul class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-700">
            <li class="flex items-start gap-2">
                <i class="fas fa-check text-green-600 mt-1 flex-shrink-0"></i>
                <span>Post items you no longer need - help others and reduce waste!</span>
            </li>
            <li class="flex items-start gap-2">
                <i class="fas fa-check text-green-600 mt-1 flex-shrink-0"></i>
                <span>Complete trades weekly - consistency matters in the rankings</span>
            </li>
            <li class="flex items-start gap-2">
                <i class="fas fa-check text-green-600 mt-1 flex-shrink-0"></i>
                <span>Leave positive reviews - build trust with the community</span>
            </li>
            <li class="flex items-start gap-2">
                <i class="fas fa-check text-green-600 mt-1 flex-shrink-0"></i>
                <span>Organize group trades - bigger impact, more waste diverted</span>
            </li>
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
