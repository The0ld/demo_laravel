<?php

namespace App\Http\Traits\Auth;

use App\Exceptions\Auth\AuthException;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\LoginUserRequest;
use App\Models\User;

trait AuthValidationTrait
{
    /**
     * Validate login.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Http\Requests\User\LoginUserRequest  $login
     * @return void
    */
    protected function validateUser(?User $user, LoginUserRequest $login)
    {
        if (!$user) {
            throw new AuthException(AuthException::INCORRECT_DATA, 422);
        } else if (!Hash::check($login->password, $user->password)) {
            throw new AuthException(AuthException::INCORRECT_DATA, 422);
        }
    }

}

?>
