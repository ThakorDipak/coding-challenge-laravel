<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\UserRegister;
use App\Exceptions\Handler;
use App\Http\Requests\AuthRequests;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    private $auth_repo;
    public function __construct(AuthRepository $auth_repo)
    {

        $this->auth_repo = $auth_repo;
        // $this->middleware('throttle:5,1')->only('resendConfirmationMail');
    }

    public function register(AuthRequests $request)
    {
        try {
            $inputs = $this->auth_repo->setInputs($request);
            $user   = $this->auth_repo->store($inputs);
            $user->assignRole($user->role);

            Mail::to($request->email)->send(new UserRegister($user));

            $response[User::STATUS] = true;
            $message = __('Please check your email to verify your account');

            return sendResponse($response, $message);
        } catch (Handler $th) {
            return sendErrorException($th, 'Unauthorized.');
        }
    }
}
