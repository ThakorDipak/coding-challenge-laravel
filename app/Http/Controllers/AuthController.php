<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\User;
use App\Mail\UserRegister;
use App\Exceptions\Handler;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequests;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\AuthResource;
use App\Repositories\AuthRepository;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $auth_repo;
    public function __construct(AuthRepository $auth_repo)
    {
        $this->auth_repo = $auth_repo;
    }

    public function login(Request $request)
    {
        try {
            $existUser = User::where(User::EMAIL, $request->email)->first();

            if ($existUser && $existUser->status !== Status::CONFIRM) {
                return sendError('Please active your account by confirming your email address.');
            } else if ($existUser && Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                Auth::login($existUser);
                $response = new AuthResource(Auth::user());
                return sendResponse($response, 'User login successfully.');
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

    public function resendVerifyMail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                User::EMAIL => 'required|exists:users,' . User::EMAIL
            ]);

            if ($validator->fails()) {
                $response['email_invalid'] = true;
                $response['validator_error'] = $validator->errors();
                return sendError('The email is invalid', $response);
            }

            $user = User::firstWhere(User::EMAIL, $request->email);
            if ($user) {
                if (!$user->email_verified_at) {
                    $user->update([
                        User::UPDATED_AT         => now(),
                        User::VERIFICATION_TOKEN =>  Str::random(90),
                    ]);
                    Mail::to($request->email)->send(new UserRegister($user));
                    $response[User::STATUS] = true;
                    $message = __('Please check your email to verify your account');
                } else {
                    $response[User::STATUS] = true;
                    $message = "Your e-mail is already verified.";
                }
                return sendResponse($response, $message);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function emailVerify(Request $request)
    {
        try {
            $validator = Validator::make($request->route()->parameters(), [
                User::TOKEN => 'required|exists:users,' . User::VERIFICATION_TOKEN
            ]);

            if ($validator->fails()) {
                $response['token_invalid'] = true;
                $response['validator_error'] = $validator->errors();
                return sendError('The selected token is invalid', $response);
            }

            $verifyUser = User::firstWhere(User::VERIFICATION_TOKEN, $request->token);

            if ($verifyUser->updated_at->addMinutes(5)->isPast()) {
                $response['token_expired'] = true;
                $response['user'] = [
                    User::ID    => $verifyUser->id,
                    User::EMAIL => $verifyUser->email,
                ];
                return sendResponse($response, 'Token has expired.');
            }

            $response[User::STATUS] = false;
            $message = 'Sorry your email cannot be identified.';
            if (!is_null($verifyUser)) {
                if (!$verifyUser->email_verified_at) {
                    $user = $verifyUser;

                    $status = Status::ADMIN_PENDING;
                    $user->update([
                        User::STATUS             => $status,
                        User::EMAIL_VERIFIED_AT  => now(),
                        User::VERIFICATION_TOKEN => NULL,
                    ]);

                    return sendResponse($response, 'Verification success.');
                } else {
                    $response[User::STATUS] = true;
                    $message = "Your e-mail is already verified. ";
                }
            }
            return sendResponse($response, $message);
        } catch (Handler $th) {
            return sendErrorException($th);
        }
    }
}
