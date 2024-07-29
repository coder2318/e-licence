<?php

namespace App\Integrations\OneID\Exceptions;


use App\Interfaces\ExceptionInterface;
use Illuminate\Http\{JsonResponse};

class OneIDClientError extends OneIDBaseException implements ExceptionInterface
{

    /**
     * Render the exception into an HTTP response.
     */
    public function render()
    {
        $error = [];
        $exp_msg = json_decode($this->getMessage(), true)['body']['errors']['provider']??[];
        foreach ($exp_msg as $item => $value){
            $error[] = [
                'field' => $item,
                'message' => [
                    [
                    'key' => 'required',
                    'text' => $value
                    ]
                ]
            ];
        }
        return $this->errorResponse($error, $this->code, $this->code);
    }

    public function errorResponse($errors, $code, $status=null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'status_code' => $status,
            'error' => $errors
        ], $code);
    }


}
