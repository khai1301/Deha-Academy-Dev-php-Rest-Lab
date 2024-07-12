<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function sentSuccessfulResponse($status=200, $message='Successful', $data='')
    {
        return response()->json([
            'status_code' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }
}
