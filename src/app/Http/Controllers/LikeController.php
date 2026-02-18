<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Like;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Item $item): RedirectResponse
    {
        $userId = Auth::id();

        if ($item->user_id === $userId) {
            return back()->with(['message' => '自分の商品にはいいねできません。']);
        }

        $like = Like::where('user_id', $userId)
            ->where('item_id', $item->id)
            ->first();

        if ($like) {
            $like->delete();
            return back();
        }

        Like::create([
            'user_id' => $userId,
            'item_id' => $item->id,
        ]);

        return back();
    }
}
