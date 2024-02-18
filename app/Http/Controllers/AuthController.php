<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\User;
use App\Mail\UserRegister;
use App\Exceptions\Handler;
use App\Http\Requests\AuthRequests;
use App\Http\Resources\AuthResource;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $auth_repo;
    public function __construct(AuthRepository $auth_repo)
    {

        $this->auth_repo = $auth_repo;
        // $this->middleware('throttle:5,1')->only('resendConfirmationMail');
    }

    public function login(Request $request)
    {
        try {
            $existUser = User::where(User::EMAIL, $request->email)->first();

            if ($existUser && $existUser->status !== Status::CONFIRM) {
                // return sendResponse([], 'Please active your account by confirming your email address.');
                return sendError('Please active your account by confirming your email address.');
            } else if ($existUser && Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                Auth::login($existUser);
                $response = new AuthResource(Auth::user());
                return sendResponse($response, 'User login successfully.');
                return sendResponse($request->all());
            }
            return sendError('Invalid email or password.', ['message' => 'Invalid email or password.']);
        } catch (Handler $th) {
            return sendErrorException($th, 'Unauthorized.');
        }
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
