<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private function requireAdmin()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Access denied. CES Admin only.');
        }
    }

    // ─── 8.4 Overview / Analytics ───────────────────────────────────────────
    public function dashboard()
    {
        $this->requireAdmin();

        $pendingBarter   = Item::where('status', 'Pending')->where('item_type', 'Barter')->count();
        $pendingDonation = Item::where('status', 'Pending')->where('item_type', 'Donation')->count();
        $activeItems     = Item::where('status', 'Active')->count();
        $totalUsers      = User::count();
        $totalPending    = $pendingBarter + $pendingDonation;

        // Recent activity feed (latest 5 pending items)
        $recentActivity = Item::where('status', 'Pending')
                              ->with('user')
                              ->latest()
                              ->limit(5)
                              ->get();

        return view('admin.dashboard', compact(
            'pendingBarter',
            'pendingDonation',
            'activeItems',
            'totalUsers',
            'totalPending',
            'recentActivity'
        ));
    }

    // ─── 8.1 + 8.2 Manage / Search Users ────────────────────────────────────
    public function users(Request $request)
    {
        $this->requireAdmin();

        $query = User::withCount('items')
                     ->whereIn('role', ['user', 'suspended'])
                     ->latest();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $users      = $query->paginate(20)->withQueryString();
        $totalUsers = User::whereIn('role', ['user', 'suspended'])->count();
        $suspended  = User::where('role', 'suspended')->count();

        return view('admin.users', compact('users', 'totalUsers', 'suspended'));
    }

    // ─── 9.0 Approve / Deny Donations ────────────────────────────────────────
    public function donations()
    {
        $this->requireAdmin();

        $pendingDonation = Item::where('status', 'Pending')
                               ->where('item_type', 'Donation')
                               ->with('user')
                               ->latest()
                               ->get();

        $approvedDonations = Item::where('status', 'Active')
                                 ->where('item_type', 'Donation')
                                 ->count();

        $deniedDonations = Item::where('status', 'Archived')
                               ->where('item_type', 'Donation')
                               ->count();

        return view('admin.donations', compact(
            'pendingDonation',
            'approvedDonations',
            'deniedDonations'
        ));
    }

    // ─── 8.3 Configure Dashboard & System Settings ───────────────────────────
    public function settings()
    {
        $this->requireAdmin();
        return view('admin.settings');
    }

    // ─── Item Actions ─────────────────────────────────────────────────────────
    public function approveItem(Item $item)
    {
        $this->requireAdmin();
        DB::table('items')->where('id', $item->id)->update(['status' => 'Active']);

        // Notify the item owner
        \App\Models\Notification::notify(
            $item->user_id,
            'item_approved',
            'Item Approved!',
            "Your item \"{$item->title}\" has been approved and is now live on the marketplace.",
            route('items.show', $item)
        );

        return back()->with('success', "✓ \"{$item->title}\" approved and is now live.");
    }

    public function rejectItem(Request $request, Item $item)
    {
        $this->requireAdmin();
        DB::table('items')->where('id', $item->id)->update(['status' => 'Archived']);

        // Notify the item owner
        \App\Models\Notification::notify(
            $item->user_id,
            'item_rejected',
            'Item Not Approved',
            "Your item \"{$item->title}\" was not approved by CES Admin. Please review our guidelines and resubmit.",
            route('items.my-items')
        );

        return back()->with('success', "✗ \"{$item->title}\" has been denied.");
    }

    // ─── User Actions ─────────────────────────────────────────────────────────
    public function suspendUser(User $user)
    {
        $this->requireAdmin();
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot suspend an admin account.');
        }
        DB::table('users')->where('id', $user->id)->update(['role' => 'suspended']);

        // Notify the suspended user
        \App\Models\Notification::notify(
            $user->id,
            'account_suspended',
            'Account Suspended',
            'Your account has been suspended by CES Admin. You cannot post items, trade, or message other users. Contact CES for more information.',
            null
        );

        return back()->with('success', "User \"{$user->name}\" has been suspended.");
    }

    public function reactivateUser(User $user)
    {
        $this->requireAdmin();
        DB::table('users')->where('id', $user->id)->update(['role' => 'user']);

        \App\Models\Notification::notify(
            $user->id,
            'account_reactivated',
            'Account Reactivated',
            'Your account has been reactivated. You can now post items, trade, and message other users.',
            route('dashboard')
        );

        return back()->with('success', "User \"{$user->name}\" has been restored.");
    }

    // ─── Reports ─────────────────────────────────────────────────────────────
    public function reports(Request $request)
    {
        $this->requireAdmin();

        $reports = \App\Models\Report::with(['reporter', 'reportedUser'])
            ->latest()
            ->paginate(20);

        return view('admin.reports', compact('reports'));
    }

    public function resolveReport(\App\Models\Report $report)
    {
        $this->requireAdmin();
        $report->update(['status' => 'Resolved']);
        return back()->with('success', 'Report marked as resolved.');
    }

    public function dismissReport(\App\Models\Report $report)
    {
        $this->requireAdmin();
        $report->update(['status' => 'Dismissed']);
        return back()->with('success', 'Report dismissed.');
    }
}
