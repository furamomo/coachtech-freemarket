<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use App\Models\Item;
use App\Models\Purchase;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $profile = $user?->profile;
        $isFirst = $profile === null;

        return view('profile.edit', compact('user', 'profile', 'isFirst'));
    }

    public function update(ProfileRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        $isFirst = $user->profile === null;

        $profile = $user->profile()->firstOrNew();

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $validated['profile_image_path'] = $path;
        }

        $user->update([
            'name' => $validated['name'],
        ]);

        $profile->fill([
            'profile_image_path' => $validated['profile_image_path'] ?? $profile->profile_image_path,
            'postal_code'        => $validated['postal_code'],
            'address'            => $validated['address'],
            'building_name'      => $validated['building_name'] ?? null,
        ]);

        $profile->save();

        if ($isFirst) {
            return redirect()->route('items.index')->with('message', 'プロフィールを登録しました');
        }

        return redirect()->route('mypage.show')->with('message', '更新しました');
    }

    public function show(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        $page = $request->query('page', 'sell');

        if ($page === 'buy') {
            $items = Item::query()->whereIn('id',Purchase::query()->where('user_id', $user->id)->pluck('item_id'))->latest()->get();
        }
        else {
            $items = Item::query()->where('user_id', $user->id)->latest()->get();
        }

        return view('profile.show', compact('user', 'profile', 'items', 'page'));
    }

}
