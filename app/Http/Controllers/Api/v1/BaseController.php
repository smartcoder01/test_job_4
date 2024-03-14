<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\JsonResponse;

class BaseController
{
    /**
     * success response method.
     *
     * @param $data
     * @param null $message
     * @return JsonResponse
     */
    public function sendResponse($data, $message = null): JsonResponse
    {
        $response = [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @return JsonResponse
     */
    public function sendError($error, array $errorMessages = [], int $code = 200): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['errors'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

}
