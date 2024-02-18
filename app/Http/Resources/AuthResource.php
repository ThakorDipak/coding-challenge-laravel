<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $token = $this->resource->createToken(config('app.name'))->plainTextToken;
        return [
            User::TOKEN       => $token,
            User::SINGLE_NAME => [
                User::ID         => $this->id,
                User::FIRST_NAME => $this->first_name,
                User::LAST_NAME  => $this->last_name,
                User::EMAIL      => $this->email,
                User::ROLE       => $this->role,
                User::STATUS     => $this->status,
            ]
        ];
    }
}
