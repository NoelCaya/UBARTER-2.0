<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Trade;
use App\Models\Review;
use Illuminate\Http\Request;

class ReputationController extends Controller
{
    /**
     * Active Traders reputation wall — #20
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'user')
            ->withCount([
                'initiatedTrades as completed_trades_count' => fn($q) => $q->where('status', 'Completed'),
                'reviewsReceived as review_count',
            ])
            ->withAvg('reviewsReceived as avg_rating', 'rating')
            ->having('completed_trades_count', '>', 0)
            ->orderByDesc('completed_trades_count');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $traders = $query->paginate(20);

        return view('reputation.index', compact('traders'));
    }

    /**
     * Individual trader profile with their reviews
     */
    public function show(User $user)
    {
        if ($user->role === 'admin') abort(404);

        $reviews = Review::where('reviewee_id', $user->id)
            ->with(['reviewer', 'item'])
            ->latest()
            ->paginate(10);

        $avgRating    = Review::where('reviewee_id', $user->id)->avg('rating') ?? 0;
        $totalReviews = Review::where('reviewee_id', $user->id)->count();

        $completedTrades = Trade::where(function ($q) use ($user) {
            $q->where('initiator_id', $user->id)->orWhere('receiver_id', $user->id);
        })->where('status', 'Completed')->count();

        $starCounts = [];
        for ($i = 1; $i <= 5; $i++) {
            $starCounts[$i] = Review::where('reviewee_id', $user->id)->where('rating', $i)->count();
        }

        return view('reputation.show', compact(
            'user', 'reviews', 'avgRating', 'totalReviews', 'completedTrades', 'starCounts'
        ));
    }
}
