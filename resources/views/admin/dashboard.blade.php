@extends('layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
<div class="p-6 md:p-8">
    <!-- Admin Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-gray-600 mt-2">Manage items, users, and disputes.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Pending Items for Approval -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-600">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Pending Approvals</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">24</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-orange-600 text-lg"></i>
                </div>
            </div>
            <button class="mt-4 text-orange-600 hover:text-orange-700 font-medium text-sm">
                Review Now →
            </button>
        </div>

        <!-- Active Items -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-600">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Active Items</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">434</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box text-blue-600 text-lg"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-4"><span class="text-green-600 font-medium">↑ 12%</span> from last month</p>
        </div>

        <!-- Reported Items/Issues -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-600">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Reports</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">8</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-flag text-red-600 text-lg"></i>
                </div>
            </div>
            <button class="mt-4 text-red-600 hover:text-red-700 font-medium text-sm">
                Review Reports →
            </button>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-600">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Active Users</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">892</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-purple-600 text-lg"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-4"><span class="text-green-600 font-medium">↑ 3.2%</span> new this month</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column (2/3) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Pending Item Approvals -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Items Pending Approval</h2>
                    <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All →</a>
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
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Recent Disputes</h2>
                    <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All →</a>
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
        <div class="space-y-8">
            <!-- User Management Quick Access -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <button class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm">
                        <i class="fas fa-user-check mr-2"></i>Manage Users
                    </button>
                    <button class="w-full px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium text-sm">
                        <i class="fas fa-ban mr-2"></i>Suspend User
                    </button>
                    <button class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium text-sm">
                        <i class="fas fa-trash mr-2"></i>Remove Item
                    </button>
                    <button class="w-full px-4 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition font-medium text-sm">
                        <i class="fas fa-bell mr-2"></i>Send Notification
                    </button>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Activity Log</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 bg-green-600 rounded-full mt-2 flex-shrink-0"></div>
                        <div>
                            <p class="text-gray-900 font-medium">Item approved</p>
                            <p class="text-gray-600 text-xs">Engineering textbook by Alex</p>
                            <p class="text-gray-500 text-xs">10 mins ago</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 bg-blue-600 rounded-full mt-2 flex-shrink-0"></div>
                        <div>
                            <p class="text-gray-900 font-medium">New user registered</p>
                            <p class="text-gray-600 text-xs">Jessica Brown - student@ub.edu.ph</p>
                            <p class="text-gray-500 text-xs">35 mins ago</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 bg-red-600 rounded-full mt-2 flex-shrink-0"></div>
                        <div>
                            <p class="text-gray-900 font-medium">Item reported</p>
                            <p class="text-gray-600 text-xs">Uniform set - inappropriate content</p>
                            <p class="text-gray-500 text-xs">1 hour ago</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 bg-yellow-600 rounded-full mt-2 flex-shrink-0"></div>
                        <div>
                            <p class="text-gray-900 font-medium">Dispute filed</p>
                            <p class="text-gray-600 text-xs">Sarah Lee vs John Doe</p>
                            <p class="text-gray-500 text-xs">2 hours ago</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-sm p-6 border border-blue-200">
                <h2 class="text-lg font-bold text-gray-900 mb-4">This Month Stats</h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-700">New Items Posted</span>
                        <span class="font-bold text-gray-900">1,245</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-700">Successful Trades</span>
                        <span class="font-bold text-gray-900">892</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-700">Donations Given</span>
                        <span class="font-bold text-gray-900">456</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-700">Satisfaction Rate</span>
                        <span class="font-bold text-gray-900">94.2%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
