<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
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
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json(
                    [
                        'status' => false,
                        'error' => [
                            'code' => 404,
                            'description' => $e->getMessage()
                        ]
                    ],
                    404
                );
            }
        });

    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException && $this->isJsonRequest($request)) {
            return response()->json([
                'status' => false,
                'error' => [
                    'type' => 'form',
                    'code' => 400,
                    'description' => 'Bad request.',
                    'detail' => $e->validator->errors()
                ]
            ], 422);
        }

        return parent::render($request, $e);
    }

    private function isJsonRequest(Request $request): bool
    {
        return $request->header('Content-Type') === 'application/json';
    }
}
