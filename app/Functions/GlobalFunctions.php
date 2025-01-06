<?php

namespace App\Functions;

use App\Response\Messages;
use App\Http\Resources\LoginResource;

class GlobalFunctions
{
    public static function responseFunction($message, $result = [])
    {
        return response()->json(
            [
                "message" => $message,
                "result" => $result,
            ],
            Messages::SUCESS_STATUS
        );
    }

    public static function save($message, $result = [])
    {
        return response()->json(
            [
                "message" => $message,
                "result" => $result,
            ],
            Messages::CREATED_STATUS
        );
    }

    public static function notFound($message)
    {
        return response()->json(
            [
                "message" => $message,
            ],
            Messages::DATA_NOT_FOUND
        );
    }
}
