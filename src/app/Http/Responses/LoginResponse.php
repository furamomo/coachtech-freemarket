<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        // 未認証なら、メール認証画面へ
        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
            // ※ Fortify標準の「認証誘導画面」
        }


        // プロフィールが未作成ならプロフィール設定へ
        if (!$user->profile) {
            return redirect()->route('profile.edit');
        }

        // プロフィールがあるならトップへ（/）
        return redirect()->intended('/');
    }
}
