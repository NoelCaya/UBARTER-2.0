<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Guard: only admin role can access these methods
     */
    private function requireAdmin()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Access denied. CES Admin only.');
        }
    }

    /**
     * Admin dashboard — shows real pending items split by type
     */
    public function dashboard()
    {
        $this->requireAdmin();

        $pendingBarter   = Item::where('status', 'Pending')->where('item_type', 'Barter')
                               ->with('user')->latest()->get();
        $pendingDonation = Item::where('status', 'Pending')->where('item_type', 'Donation')
                               ->with('user')->latest()->get();
        $activeItems     = Item::where('status', 'Active')->count();
        $totalUsers      = User::count();
        $totalPending    = $pendingBarter->count() + $pendingDonation->count();

        // Recent users for 8.1 Manage User Accounts panel (most recent 8)
        $recentUsers = User::withCount('items')
                           ->whereIn('role', ['user', 'suspended', 'admin'])
                           ->latest()
                           ->limit(8)
                           ->get();

        return view('admin.dashboard', compact(
            'pendingBarter',
            'pendingDonation',
            'activeItems',
            'totalUsers',
            'totalPending',
            'recentUsers'
        ));
    }

    /**
     * Approve an item — sets status to Active
     */
    public function approveItem(Item $item)
    {
        $this->requireAdmin();

        // Use DB directly to bypass any fillable issues
        DB::table('items')->where('id', $item->id)->update(['status' => 'Active']);

        return back()->with('success', "✓ \"{$item->title}\" approved and is now live in the marketplace.");
    }

    /**
     * Reject an item — sets status to Archived
     */
    public function rejectItem(Request $request, Item $item)
    {
        $this->requireAdmin();

        DB::table('items')->where('id', $item->id)->update(['status' => 'Archived']);

        return back()->with('success', "✗ \"{$item->title}\" has been rejected.");
    }

    /**
     * List all users
     */
    public function users()
    {
        $this->requireAdmin();

        $users = User::whereIn('role', ['user', 'suspended'])
                     ->withCount('items')
                     ->latest()
                     ->paginate(20);

        return view('admin.users', compact('users'));
    }

    /**
     * Suspend a user — use DB directly to bypass fillable
     */
    public function suspendUser(User $user)
    {
        $this->requireAdmin();

        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot suspend an admin account.');
        }

        DB::table('users')->where('id', $user->id)->update(['role' => 'suspended']);

        return back()->with('success', "User \"{$user->name}\" has been suspended.");
    }

    /**
     * Reactivate a suspended user
     */
    public function reactivateUser(User $user)
    {
        $this->requireAdmin();

        DB::table('users')->where('id', $user->id)->update(['role' => 'user']);

        return back()->with('success', "User \"{$user->name}\" has been reactivated.");
    }
}
