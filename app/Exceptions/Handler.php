<?php

namespace App\Exceptions;

use App\Http\Responses\ErrorInternalServerErrorResponse;
use App\Http\Responses\ErrorMethodNotAllowedResponse;
use App\Http\Responses\ErrorNotFoundResponse;
use App\Http\Responses\ErrorTokenExpired;
use App\Http\Responses\ErrorTooManyAttemptsResponse;
use App\Http\Responses\ErrorUnauthenticatedResponse;
use App\Http\Responses\ErrorValidationResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function(Throwable $e, $request) {
            if($request->is('api/*')) {
                $response = null;

                if($e instanceof HttpResponseException) {
                    return null;
                } elseif($e instanceof AuthenticationException || $e instanceof RouteNotFoundException) {
                    $response = ErrorUnauthenticatedResponse::make();
                } elseif($e instanceof ValidationException) {
                    $response = ErrorValidationResponse::make($e->errors());
                } elseif($e instanceof ThrottleRequestsException) {
                    $response = ErrorTooManyAttemptsResponse::make();
                } elseif($e instanceof MethodNotAllowedHttpException){
                    $response = ErrorMethodNotAllowedResponse::make();
                }elseif($e instanceof NotFoundHttpException){
                    $response = ErrorNotFoundResponse::make();
                }elseif($e instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException){
                    $response = ErrorTokenExpired::make();
                }


                $errorMessage = config('app.debug')
                    ? $e->getMessage()
                    : '';

                if(! $response) {
                    $response = ErrorInternalServerErrorResponse::make($errorMessage);
                }

                if($response instanceof Response && $e instanceof HttpException) {
                    $headers = $e->getHeaders();
                    $response->headers->add($headers);
                }

                return $response;
            }

            return null;
        });
    }


    protected function shouldReturnJson($request, Throwable $e): bool
    {
        if($request->is('api/*')) {
            return true;
        }

        return parent::shouldReturnJson($request, $e);
    }
}
