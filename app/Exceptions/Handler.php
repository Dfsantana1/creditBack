<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Throwable;
use Illuminate\Support\Facades\Log;

/**
 * Class Handler
 *
 * @category Exceptions
 * @package  App\Exceptions

 */
class Handler extends ExceptionHandler
{

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, LogLevel::*>
     */
    protected $levels = [];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(
            function (Throwable $e) {
            }
        );

    }//end register()


    /**
     * Render an exception into an HTTP response.
     *
     * @param Request             $request // Request
     * @param Exception|Throwable $e       // Exception
     *
     * @return JsonResponse| Response
     *
     * @throws Throwable
     */
    public function render($request, Exception|Throwable $e): JsonResponse | Response
    {
log::info('request'.$request);
        if ($e instanceof ModelNotFoundException) {
            return response()->json(['error' => 'Record not found.'])
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        } else {
            if ($e instanceof NotFoundHttpException) {
                return response()->json(['error' => 'URL not found.'])
                    ->setStatusCode(Response::HTTP_NOT_FOUND);
            } else {
                if ($e instanceof ValidationException) {
                    return response()->json(
                        [
                            'message' => $e->getMessage(),
                            'errors'  => $e->errors(),
                        ]
                    )
                        ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            }
        }

        $segments = collect(request()->segments());

        if (!$segments->contains('saml2') && !$request->expectsJson()) {
            return response()->json(['error' => 'Expects Json'])
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        return parent::render($request, $e);

    }//end render()


}//end class
