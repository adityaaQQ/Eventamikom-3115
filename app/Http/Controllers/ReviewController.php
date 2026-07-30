<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Cek apakah user sudah pernah beri review di event ini
        $existingReview = Review::where('user_id', Auth::id())
            ->where('event_id', $event->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk acara ini.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Ulasan dan penilaian berhasil dikirim!');
    }
}