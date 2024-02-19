<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            User::FIRST_NAME => 'required',
            User::LAST_NAME  => 'required',
            User::EMAIL      => 'required|' . Rule::unique(User::TABLE_NAME, User::EMAIL)->ignore($this->id),
        ];
    }
}
