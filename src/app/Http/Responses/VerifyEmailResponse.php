<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\VerifyEmailResponse as VerifyEmailResponseContract;

class VerifyEmailResponse implements VerifyEmailResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        if (!$user->profile) {
            return redirect()->route('profile.edit');
        }

        return redirect()->intended('/');
    }
}
