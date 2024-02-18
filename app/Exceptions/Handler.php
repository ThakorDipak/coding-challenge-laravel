<?php

namespace App\Exceptions;

use Error;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            $message = __($exception->getMessage());
            return  sendError($message, [
                'status'   => $exception->status,
                'errorBag' => $exception->errorBag,
                'message'  => $exception->getMessage(),
                'error'    => $exception->errors(),
            ]);
        }
        
        // if ($exception instanceof Error) {
        //     return sendError('Error.', [
        //         'message'   => $exception->getMessage(),
        //         'file'      => $exception->getFile(),
        //         'line'      => $exception->getLine(),
        //         'exception' => 'Error',
        //     ]);
        // }
    }
}
