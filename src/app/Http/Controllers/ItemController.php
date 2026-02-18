<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');

        $keyword = $request->query('keyword');

        $query = Item::query()
            ->withCount('likes');

        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        if ($tab === 'mylist') {
            if (!Auth::check()) {
                $items = collect();
                return view('items.index', compact('items', 'tab', 'keyword'));
            }

            $userId = Auth::id();

            $query->whereHas('likes', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        } else {
            if (Auth::check()) {
                $query->where('user_id', '!=', Auth::id());
            }
        }

        $items = $query->latest()->get();

        return view('items.index', compact('items', 'tab', 'keyword'));
    }

    public function show(Item $item)
    {
        $item->load(['categories', 'comments.user.profile'])
            ->loadCount('likes');

        $conditions = Item::CONDITION_LABELS;

        $userId = auth()->id();
        $isOwner = auth()->check() && $item->user_id === $userId;

        $canPurchase = auth()->check() && !$isOwner && !$item->is_sold;
        $canLike = auth()->check() && !$isOwner;

        $isLiked = $canLike
            ? $item->likes()->where('user_id', $userId)->exists()
            : false;

        $likesCount = $item->likes_count;

        return view('items.show', compact('item', 'conditions', 'likesCount', 'isLiked', 'isOwner', 'canPurchase', 'canLike' ));
    }


    public function create()
    {
        $categories = Category::orderBy('id')->get();

        $conditions = \App\Models\Item::CONDITION_LABELS;

        return view('items.create', compact('categories', 'conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        $validated = $request->validated();

        $path = $request->file('image')->store('items', 'public');

        $item = Item::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'brand_name' => $validated['brand_name'] ?? null,
            'description' => $validated['description'],
            'price' => $validated['price'],
            'image_path' => $path,
            'condition' => $validated['condition'],
            'is_sold' => false,
        ]);

        $item->categories()->sync($validated['category_ids']);

        return redirect()->route('mypage.show', ['tab' => 'sell'])->with('message', '商品を出品しました');
    }
}
