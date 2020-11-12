<?php


namespace App\Traits;


use Illuminate\Support\Collection;

trait ApiResponser
{
    private function successResponse($data, $code){

        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code){

        return response()->json([
            'error' => $message,
            'code' => $code
        ], $code);
    }

   
}
