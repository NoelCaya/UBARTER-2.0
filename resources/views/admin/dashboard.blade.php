@extends('layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
<div class="px-4 md:px-6 py-6 max-w-7xl mx-auto">
    <!-- Admin Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-gray-500 text-sm mt-1">Manage items, users, and disputes.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Pending Items for Approval -->
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-orange-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">Pending Approvals</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1.5">24</p>
                </div>
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-clock text-orange-500 text-sm"></i>
                </div>
            </div>
            <button class="mt-3 text-orange-600 hover:text-orange-700 font-semibold text-xs">Review Now →</button>
        </div>

        <!-- Active Items -->
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">Active Items</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1.5">434</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-box text-blue-500 text-sm"></i>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-3"><span class="text-green-600 font-semibold">↑ 12%</span> from last month</p>
        </div>

        <!-- Reported Items/Issues -->
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">Reports</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1.5">8</p>
                </div>
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-flag text-red-500 text-sm"></i>
                </div>
            </div>
            <button class="mt-3 text-red-600 hover:text-red-700 font-semibold text-xs">Review Reports →</button>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">Active Users</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1.5">892</p>
                </div>
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-users text-purple-500 text-sm"></i>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-3"><span class="text-green-600 font-semibold">↑ 3.2%</span> new this month</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <!-- Left Column (2/3) -->
        <div class="lg:col-span-2 space-y-5">
            <!-- Pending Item Approvals -->
            <div class="bg-white rounded-xl shadow-sm p-5">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-base font-bold text-gray-900">Items Pending Approval</h2>
                    <a href="#" class="text-[#7b0f10] hover:underline text-xs font-semibold">View All →</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900">Item</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900">Posted By</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900">Date</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-900">Action</th>
                            </tr>
                        </thead>
                        <tbody class="border-b border-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <img src="https://via.placeholder.com/40x40?text=Book" class="w-10 h-10 rounded-lg object-cover">
                                        <span class="text-sm font-medium text-gray-900">Calculus Textbook</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">Books</td>
                                <td class="px-6 py-4 text-sm text-gray-600">John Doe</td>
                                <td class="px-6 py-4 text-sm text-gray-600">2 hours ago</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center items-center space-x-2">
                                        <button class="px-3 py-1 bg-green-100 text-green-700 rounded text-xs font-medium hover:bg-green-200">
                                            Approve
                                        </button>
                                        <button class="px-3 py-1 bg-red-100 text-red-700 rounded text-xs font-medium hover:bg-red-200">
                                            Reject
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <img src="https://via.placeholder.com/40x40?text=Uniform" class="w-10 h-10 rounded-lg object-cover">
                                        <span class="text-sm font-medium text-gray-900">University Uniform</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">Apparel</td>
                                <td class="px-6 py-4 text-sm text-gray-600">Maria Santos</td>
                                <td class="px-6 py-4 text-sm text-gray-600">5 hours ago</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center items-center space-x-2">
                                        <button class="px-3 py-1 bg-green-100 text-green-700 rounded text-xs font-medium hover:bg-green-200">
                                            Approve
                                        </button>
                                        <button class="px-3 py-1 bg-red-100 text-red-700 rounded text-xs font-medium hover:bg-red-200">
                                            Reject
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Disputes -->
            <div class="bg-white rounded-xl shadow-sm p-5">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-base font-bold text-gray-900">Recent Disputes</h2>
                    <a href="#" class="text-[#7b0f10] hover:underline text-xs font-semibold">View All →</a>
                </div>

                <div class="space-y-4">
                    <div class="border border-red-200 bg-red-50 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-semibold text-gray-900">Item condition mismatch claim</p>
                                <p class="text-sm text-gray-600 mt-1">Users: Sarah Lee vs John Doe - Item: Calculus Book</p>
                            </div>
                            <span class="px-2 py-1 bg-red-200 text-red-800 rounded text-xs font-semibold">Urgent</span>
                        </div>
                        <div class="flex space-x-2">
                            <button class="px-3 py-2 text-sm bg-red-600 hover:bg-red-700 text-white rounded font-medium">
                                Review Case
                            </button>
                            <button class="px-3 py-2 text-sm border border-gray-300 text-gray-700 rounded font-medium hover:bg-gray-50">
                                Contact Both
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column (1/3) -->
        <div class="space-y-5">
            <!-- User Management Quick Access -->
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h2 class="text-sm font-bold text-gray-900 mb-3">Quick Actions</h2>
                <div class="space-y-2">
                    <button class="w-full px-4 py-2.5 bg-[#7b0f10] text-white rounded-lg hover:bg-[#5a0a0b] transition font-semibold text-sm">
                        <i class="fas fa-user-check mr-2"></i>Manage Users
                    </button>
                    <button class="w-full px-4 py-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold text-sm">
                        <i class="fas fa-ban mr-2"></i>Suspend User
                    </button>
                    <button class="w-full px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold text-sm">
                        <i class="fas fa-trash mr-2"></i>Remove Item
                    </button>
                    <button class="w-full px-4 py-2.5 bg-[#f5c518] text-[#7b0f10] rounded-lg hover:bg-[#e6b800] transition font-semibold text-sm">
                        <i class="fas fa-bell mr-2"></i>Send Notification
                    </button>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h2 class="text-sm font-bold text-gray-900 mb-3">Activity Log</h2>
                <div class="space-y-3 text-xs">
                    <div class="flex items-start gap-2.5">
                        <div class="w-2 h-2 bg-green-500 rounded-full mt-1 flex-shrink-0"></div>
                        <div>
                            <p class="text-gray-900 font-semibold">Item approved</p>
                            <p class="text-gray-500">Engineering textbook by Alex</p>
                            <p class="text-gray-400 mt-0.5">10 mins ago</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mt-1 flex-shrink-0"></div>
                        <div>
                            <p class="text-gray-900 font-semibold">New user registered</p>
                            <p class="text-gray-500">Jessica Brown - student@ub.edu.ph</p>
                            <p class="text-gray-400 mt-0.5">35 mins ago</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <div class="w-2 h-2 bg-red-500 rounded-full mt-1 flex-shrink-0"></div>
                        <div>
                            <p class="text-gray-900 font-semibold">Item reported</p>
                            <p class="text-gray-500">Uniform set - inappropriate content</p>
                            <p class="text-gray-400 mt-0.5">1 hour ago</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mt-1 flex-shrink-0"></div>
                        <div>
                            <p class="text-gray-900 font-semibold">Dispute filed</p>
                            <p class="text-gray-500">Sarah Lee vs John Doe</p>
                            <p class="text-gray-400 mt-0.5">2 hours ago</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-gradient-to-br from-[#7b0f10]/5 to-[#f5c518]/10 rounded-xl shadow-sm p-5 border border-[#7b0f10]/10">
                <h2 class="text-sm font-bold text-gray-900 mb-3">This Month Stats</h2>
                <div class="space-y-2.5 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">New Items Posted</span>
                        <span class="font-bold text-gray-900">1,245</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Successful Trades</span>
                        <span class="font-bold text-gray-900">892</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Donations Given</span>
                        <span class="font-bold text-gray-900">456</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Satisfaction Rate</span>
                        <span class="font-bold text-green-600">94.2%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
