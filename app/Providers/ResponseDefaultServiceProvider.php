<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Response;

class ResponseDefaultServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Illuminate\Contracts\Routing\ResponseFactory::class, function() {
            return new \Laravel\Lumen\Http\ResponseFactory();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        Response::macro('default', function ($response_code = 200, $message = "Empty", $data = null) {
            if (env('APP_DEBUG', true) && $response_code > 299) {
                if (strpos($message, 'SQLSTATE') !== false) {
                    $message = 'Please Try Again';
                }
            }

            if (env('APP_DEBUG', true) == false) {
                if ($data instanceof \Exception) {
                    $message = 'Something went wrong';
                }
            }            

            return Response::make([
                'status' => [
                    'code' => $response_code,
                    'desc' => $message,
                ],
                'data' => (is_null($data)) ? (object) null : ((is_array($data)) ? (array) $data : (object) $data),
            ], $response_code);
        });
    }
}
