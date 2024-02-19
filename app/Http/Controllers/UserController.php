<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\Status;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserListCollection;
use App\Http\Resources\UsersResource;

class UserController extends Controller
{
    private $user_repo;
    public function __construct(UserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function index(Request $request)
    {
        try {
            $response = [
                'users' => new UserListCollection($this->user_repo->index($request))
            ];
            $message = __('User List');
            return sendResponse($response, $message);
        } catch (Handler $th) {
            return sendErrorException($th);
        }
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $inputs = $this->user_repo->getUserUpdateInputs($request);
            $user = $this->user_repo->update($user, $inputs);
            $response[User::STATUS] = true;

            $message = __('update success');
            return sendResponse($response, $message);
        } catch (Handler $th) {
            return sendErrorException($th);
        }
    }


    public function singleStatusUpdate(User $user, $status)
    {
        try {
            if ($user) {
                $user->update([User::STATUS => $status]);
                $message = __('Status update success');
                return sendResponse([], $message);
            }
        } catch (Handler $th) {
            return sendErrorException($th);
        }
    }

    public function userStatus(Request $request)
    {
        try {
            $statusUpdate = $request->status_update;

            foreach ($statusUpdate as $key => $item) {
                $user = User::find($item['id']);
                if ($user) {
                    $user->update([User::STATUS => $item['status']]);
                }
            }

            $message = __('Status update success');
            return sendResponse([], $message);
        } catch (Handler $th) {
            return sendErrorException($th);
        }
    }

    public function userDestroy(Request $request)
    {
        try {
            $this->user_repo->bulkDestroy($request);
            $message = __('Delete success');
            return sendResponse([], $message);
        } catch (Handler $th) {
            return sendErrorException($th);
        }
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        try {
            $message = 'Show success';
            $response = [
                'user' => new UsersResource($user)
            ];
            return sendResponse($response, $message);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function destroy(User $user)
    {
        try {
            $this->user_repo->destroy($user);
            $message = __('Delete success');
            return sendResponse([], $message);
        } catch (Handler $th) {
            return sendErrorException($th);
        }
    }
}
