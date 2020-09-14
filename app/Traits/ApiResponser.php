<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponser
{

    /**
     * @param $message
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $code)
    {
        if (is_string($message)) {
            $message = ['message' => [$message]];
        }
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    public function errorResponseWithMessage(
        $data = [],
        $message = '',
        $code = Response::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse {
        return response()->json(['code' => $code, 'message' => $message, 'data' => $data], $code);
    }

    /**
     * @param $data
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, $code = 200)
    {
        return response()->json(['data' => $data, 'code' => $code, 'content-type' => 'application/json', 'cache-control' => 'no-cache']);
    }

    public function successResponseWithMessage($data = [], $message = "", $code = 200)
    {
        $response['code']    = $code;
        $response['message'] = $message;
        $response['data']    = $data;

        $headers = [
            'content-type'  => 'application/json',
            'cache-control' => 'no-cache',
        ];
        return response()->json($response, $code, $headers);
    }

    /**
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }
}
