<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Enums\Status;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AuthRequests extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $prepareInputs = [];
        $prepareInputs[User::STATUS] = $this->status ?? Status::PENDING;
        $this->merge($prepareInputs);
    }

    public function rules(): array
    {
        return [
            User::FIRST_NAME => 'required',
            User::LAST_NAME  => 'required',
            User::PASSWORD   => 'required|min:8',
            User::EMAIL      => 'required|email|' . Rule::unique(User::TABLE_NAME, User::EMAIL),
        ];
    }
}
