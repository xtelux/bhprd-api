<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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
        // TOKEN EXPIRED
        $this->renderable(function (TokenExpiredException $e, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Session anda telah berakhir, silakan login kembali'
            ], 401);
        });

        // TOKEN TIDAK VALID
        $this->renderable(function (TokenInvalidException $e, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid'
            ], 401);
        });

        // TOKEN TIDAK DIKIRIM
        $this->renderable(function (JWTException $e, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak ditemukan'
            ], 401);
        });

        // UNAUTHENTICATED (auth:api gagal)
        $this->renderable(function (UnauthorizedHttpException $e, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum login atau session telah habis'
            ], 401);
        });

        // UNAUTHENTICATED (auth:sanctum gagal)
        $this->renderable(function (AuthenticationException $e, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Token tidak valid atau sudah logout.'
            ], 401);
        });
    }
}
