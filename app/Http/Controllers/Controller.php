<?php

namespace App\Http\Controllers;

use App\Src\Callback;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function responseBody($message, $body = [], $httpStatus = null)
    {
        $toJson = Callback::response($message)
            ->httpStatus($httpStatus)
            ->success($body);
        return response()->json(json_decode($toJson), $httpStatus ?? 200);
    }

    public function responseError($message, $args = [], $httpStatus = null)
    {
        $toJson = Callback::response($message)
            ->httpStatus($httpStatus)
            ->error($args);
        return response()->json(json_decode($toJson), $httpStatus ?? 400);
    }
}
