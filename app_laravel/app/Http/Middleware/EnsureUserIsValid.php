<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\{Auth};
use App\Exceptions\Auth\AuthException;
use Illuminate\Support\Facades\Log;

class EnsureUserIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $authUser = Auth::user()->id;
            $user = $request->route()->parameters()['user']->id;
            if ($authUser == $user)
                return $next($request);

                throw new AuthException(AuthException::NO_VALID, 403);

        } catch (AuthException $e) {
            return response()->json(['error' => $e->getCustomMessage()], $e->getCustomCode());
        } catch (\Exception $e) {
            Log::critical('Exception: ' . $e);
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
