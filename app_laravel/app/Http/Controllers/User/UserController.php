<?php

namespace App\Http\Controllers\User;

use App\Exceptions\Auth\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\{Log, DB, Auth};

class UserController extends Controller
{
    /**
     * Return a listing of the User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return UserResource::collection(User::all());
        } catch (\Exception $e) {
            Log::critical('Exception UserController: ' . $e);
            return response()->json(['error_controlado' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified User.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        try {
            return new UserResource($user);
        } catch (\Exception $e) {
            Log::critical('Exception UserController: ' . $e);
            return response()->json(['error_controlado' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified User in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            if (Auth::user()->id == $user->id) {
                $user->fill($request->all());
                $user->save();
            } else {
                $message = 'You don\'t have authorization to do this action';
                return response()->json(['data' => $message], 403);
            }

            DB::commit();

            return new UserResource($user);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception UserController: ' . $e);
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();

            $message = '';

            if (Auth::user()->id == $user->id) {
                $user->delete();
                $message = 'You have successfully deleted the user';
            } else {
                $message = 'You don\'t have authorization to do this action';
                return response()->json(['data' => $message], 403);
            }

            DB::commit();

            return response()->json(['data' => $message], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception UserController: ' . $e);
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
