<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\UserResource;

class AuthReource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'token_type'   => 'Bearer',
            'access_token' => $this->resource['access_token'],
            'user'         => new UserResource($this->resource['user'])
        ];
    }
}
