<?php

function sendResponse($result = [], $message = '')
{
    $response = [
        'success' => true,
        'message' => $message,
        'data'    => $result,
    ];

    return response()->json($response, 200);
}

function sendError($errorMessages, $error = [], $code = 500)
{
    $response = [
        'success' => false,
        'message' => $errorMessages,
        'data'    => $error,
    ];

    return response()->json($response, $code);
}

function sendErrorException($th, $errorMessages = 'errors', $code = 500)
{
    $error = NUll;
    if (config('app.env') != 'production') {
        $error = [
            "message" => $th->getMessage(),
            "file"    => $th->getFile(),
            "line"    => $th->getLine()
        ];
    }

    $response = [
        'success' => false,
        'message' => $errorMessages,
        'data' => $error,
    ];

    return response()->json($response, $code);
}
