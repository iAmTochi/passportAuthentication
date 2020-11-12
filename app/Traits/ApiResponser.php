<?php


namespace App\Traits;


use Illuminate\Support\Collection;

trait ApiResponser
{

    private function successResponse($data, $code){

        return response()->json($data, $code);
    }


}
