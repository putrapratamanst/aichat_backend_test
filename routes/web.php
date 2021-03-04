<?php

/** @var \Laravel\Lumen\Routing\Router $router */


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get("customer-eligible-check/{customerId}", "\App\Http\Controllers\CustomerController@customerEligibleCheck");
$router->post("validate-photo-submission", "\App\Http\Controllers\PhotoController@validatePhotoSubmission");
