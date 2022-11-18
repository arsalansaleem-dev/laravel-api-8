<?php

namespace App\Traits;

trait Response
{
   
    public function coreResponse($message, $data = null, $statusCode, $isSuccess = true)
    {
     
        // Send the response
        if($isSuccess) {
            return response()->json([
                'message' => $message,
                'status' => "SUCCESS",
                'code' => $statusCode,
                'results' => $data
            ], $statusCode);
        } else {
            return response()->json([
                'message' => $message,
                'status' => "ERROR",
                'code' => $statusCode,
            ], $statusCode);
        }
    }

   
    public function success($message, $data, $statusCode = 200)
    {
        return $this->coreResponse($message, $data, $statusCode);
    }

   
    public function error($message, $statusCode = 500)
    {
        return $this->coreResponse($message, null, $statusCode, false);
    }
}
