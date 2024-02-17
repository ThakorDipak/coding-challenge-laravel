<?php

namespace App\Http\Resources;

use App\Models\Base;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListResource extends JsonResource
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
            User::ROLE       => $this->role,
            User::EMAIL      => $this->email,
            User::IMAGE      => $this->image,
            User::STATUS     => $this->status,
        ];
    }
}
