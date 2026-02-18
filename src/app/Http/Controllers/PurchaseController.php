<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PurchaseController extends Controller
{
    public function create(Item $item)
    {
        if ($item->is_sold || $item->user_id === Auth::id()) {
            return redirect()->route('items.show', $item);
        }

        $profile = $this->requireProfile();
        if ($profile instanceof \Illuminate\Http\RedirectResponse) {
            return $profile;
        }

        $currentItemId = session('purchase_item_id');
        if ((int) $currentItemId !== (int) $item->id) {
            session()->forget('purchase_payment_method');
            session(['purchase_item_id' => $item->id]);
        }

        $purchaseShipping = session('purchase_shipping', [
            'shipping_postal_code' => $profile->postal_code,
            'shipping_address' => $profile->address,
            'shipping_building_name' => $profile->building_name,
        ]);

        $shipping = [
            'postal_code' => $purchaseShipping['shipping_postal_code'],
            'address' => $purchaseShipping['shipping_address'],
            'building_name' => $purchaseShipping['shipping_building_name'],
        ];

        $selectedPaymentMethod = old('payment_method') ?? session('purchase_payment_method');

        $paymentMethodLabel = '未選択';
        if ($selectedPaymentMethod === '1') {
            $paymentMethodLabel = 'コンビニ支払い';
        } elseif ($selectedPaymentMethod === '2') {
            $paymentMethodLabel = 'カード支払い';
        }

        $paymentMethod = session('purchase_payment_method');

        return view('items.purchase', compact('item', 'profile', 'shipping', 'selectedPaymentMethod', 'paymentMethodLabel'));
    }

    private function requireProfile()
    {
        $profile = Auth::user()->profile;

        if (!$profile) {
            return redirect()
                ->route('profile.edit')
                ->with(['message' => '購入するにはプロフィール（住所）を登録してください。']);
        }

        return $profile;
    }


    public function editAddress(Request $request, Item $item)
    {
        if ($item->is_sold || $item->user_id === Auth::id()) {
            return redirect()->route('items.show', $item);
        }

        $profile = $this->requireProfile();
        if ($profile instanceof \Illuminate\Http\RedirectResponse) {
            return $profile;
        }

        if ($request->filled('payment_method')) {
            session(['purchase_payment_method' => $request->payment_method]);
        }


        $purchaseShipping = session('purchase_shipping', [
            'shipping_postal_code' => $profile->postal_code,
            'shipping_address' => $profile->address,
            'shipping_building_name' => $profile->building_name,
        ]);

        return view('items.address', compact('item', 'purchaseShipping'));
    }

    public function updateAddress(AddressRequest $request, Item $item)
    {
        if ($item->is_sold || $item->user_id === Auth::id()) {
            return redirect()->route('items.show', $item);
        }

        session([
            'purchase_shipping' => $request->only([
            'shipping_postal_code',
            'shipping_address',
            'shipping_building_name',
            ]),
        ]);

        return redirect()->route('purchase.create', $item);
    }

    public function checkout(PurchaseRequest $request, Item $item)
    {
        if ($item->is_sold || $item->user_id === Auth::id()) {
            return redirect()->route('items.show', $item);
        }

        $profile = $this->requireProfile();
        if ($profile instanceof \Illuminate\Http\RedirectResponse) {
            return $profile;
        }

        $purchaseShipping = session('purchase_shipping', [
            'shipping_postal_code' => $profile->postal_code,
            'shipping_address' => $profile->address,
            'shipping_building_name' => $profile->building_name,
        ]);

        $paymentMethod = $request->payment_method;

        try {
            DB::transaction(function () use ($item, $purchaseShipping, $paymentMethod) {
                $lockedItem = Item::where('id', $item->id)->lockForUpdate()->first();

                if ($lockedItem->is_sold) {
                    throw new \RuntimeException('すでに購入されています。');
                }

                if ($lockedItem->user_id === Auth::id()) {
                    throw new \RuntimeException('自分の商品は購入できません。');
                }

                Purchase::create([
                    'user_id' => Auth::id(),
                    'item_id' => $lockedItem->id,
                    'payment_method' => $paymentMethod,
                    'shipping_postal_code' => $purchaseShipping['shipping_postal_code'],
                    'shipping_address' => $purchaseShipping['shipping_address'],
                    'shipping_building_name' => $purchaseShipping['shipping_building_name'],
                ]);

                $lockedItem->update(['is_sold' => true]);
            }, 3);
        } catch (\RuntimeException $e) {
            return back()->withInput()->withErrors(['message' => $e->getMessage()]);
        } catch (\Throwable $e) {
            return back()->withInput()->with(['message' => '購入処理に失敗しました。もう一度お試しください。']);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => $item->price,
                    'product_data' => [
                        'name' => $item->name,
                    ],
                ],
            ]],
            'success_url' => route('purchase.success', $item),
            'cancel_url' => route('purchase.cancel', $item),
        ]);

        return redirect()->away($session->url);
    }

    public function success()
    {
        session()->forget(['purchase_shipping', 'purchase_payment_method', 'purchase_item_id']);

        return redirect()->route('items.index')
            ->with('message', '決済が完了しました。');
    }

    public function cancel()
    {
        session()->forget(['purchase_shipping', 'purchase_payment_method', 'purchase_item_id']);

        return redirect()->route('items.index')
            ->with(['massage' => '決済をキャンセルしました。']);
    }
}
