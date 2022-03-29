<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Http\Requests\User\{StoreUserRequest, LoginUserRequest};
use App\Http\Resources\Auth\AuthReource;
use App\Models\User;
use Illuminate\Support\Facades\{Log, DB, Auth};
use App\Http\Traits\Auth\AuthValidationTrait;

class AuthController extends Controller
{
    use AuthValidationTrait;
    /**
     * Login a User.
     *
     * @param  \App\Http\Requests\User\LoginUserRequest  $loginRequest
     * @return \Illuminate\Http\Response
    */
    public function login(LoginUserRequest $loginRequest)
    {
        try {
            $user = User::where('email', $loginRequest->email)->first();

            $this->validateUser($user, $loginRequest);

            $response = new AuthReource([
                'access_token' => $user->createToken('demo')->accessToken,
                'user'         => $user
            ]);

            return  $response;
        } catch (\Exception $e) {
            Log::critical('Exception UserController: ' . $e);
            return response()->json(['error_controlado' => $e->getMessage()], 500);
        }
    }

    /**
     * logout a User.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function logout(User $user)
    {
        try {
            $user->OauthAcessToken()->delete();

            return response()->json(['data' => 'You have successfully logged out'], 200);
        } catch (\Exception $e) {
            Log::critical('Exception UserController: ' . $e);
            return response()->json(['error_controlado' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            $response = new AuthReource([
                'access_token' => $user->createToken('demo')->accessToken,
                'user'         => $user
            ]);

            DB::commit();

            return $response;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception UserController: ' . $e);
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
