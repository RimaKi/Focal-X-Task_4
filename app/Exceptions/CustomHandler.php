<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;


abstract class CustomHandler
{
    /**
     * Capture and model the shape of errors
     * @param Exceptions $exceptions
     * @return void
     */
    static public function init(Exceptions $exceptions)
    {
        $exceptions->shouldRenderJsonWhen(fn() => true);
        $exceptions->renderable(function (NotFoundHttpException|Throwable $e) {
            $message = null;
            $code = null;

            if ($e instanceof NotFoundHttpException) {
                $message = 'Not Found.';
                $code = 404;
            }
            if ($e instanceof AuthenticationException) {
                $message = "trans.unauthenticated";
                $code = 401;
            }
            if ($e instanceof AuthorizationException || $e instanceof UnauthorizedException) {
                $message = "Access Denied!!";
                $code = 403;
            }
            if ($e instanceof ValidationException) {
                $message = $e->errors();
            }
            $extra = [];
            if (env("APP_DEBUG", false)) {
                $extra = [
                    "details" => $e->getTrace()
                ];
            }
            return response()->json([
                'success' => false,
                'message' => $message != null ? $message : $e->getMessage(),
                ...$extra
            ], $code != null ? $code : ($e->getCode() >= 100 && $e->getCode() < 600 ? $e->getCode() : 402));
        });

    }
}
