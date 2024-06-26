<?php

namespace App\Libraries;


class Utilities
{
    /**
    * success response method.
    *
    * @return \Illuminate\Http\Response
    */
    public static function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, Response::HTTP_OK);
    }

   /**
    * return error response.
    *
    * @return \Illuminate\Http\Response
    */

    public static function sendError($error, $errorMessages = [], $code = Response::HTTP_NOT_FOUND)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}
