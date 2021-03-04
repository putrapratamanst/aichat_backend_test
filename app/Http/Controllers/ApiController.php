<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    public function imageRecognition($params)
    {
        $endpoint = 'image-recognition';
        // $value    = Http::post(env('BASE_URL_IMAGE_RECOGNITION') . $endpoint, $params);
        return true;
    }

}
