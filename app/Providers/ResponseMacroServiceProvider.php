<?php

namespace App\Providers;

use App\Exceptions\ShivEnigma\ValidationError;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Lang;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * For validation errors general format
         */
        Response::macro('invalid', function (ValidationError $v, $message = 'messages.INVALID-INPUT', $status = 422) {
            $response = array(
                "success" => false,
                "message" => Lang::get($message),
                "error" => $v->getErrors(),
            );
            return Response::make($response,$status);
        });

        /**
         * For not found ids, general format
         */
        Response::macro('notFound', function ($message = 'messages.NOT-FOUND',$status = 404) {
            $response = array(
                "success" => false,
                "message" => Lang::get($message),
            );
            return Response::make($response, $status);
        });

        /**
         * For serious errors, which can only be catched in exception
         */
        Response::macro('error', function($message = 'messages.SOMETHING-WRONG', $status = 500) {
            $response = array(
                "success" => false,
                "message" => Lang::get($message),
            );
            return Response::make($response, $status);
        });
    }
}

