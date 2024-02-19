<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            User::ID         => $this->id,
            User::FIRST_NAME => $this->first_name,
            User::LAST_NAME  => $this->last_name,
            User::STATUS     => $this->status,
            User::EMAIL      => $this->email,
        ];
    }
}
