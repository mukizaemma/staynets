<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\QueryException;
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
    }

    /**
     * Render an exception so users never see raw SQL or internal error details.
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof QueryException) {
            $message = 'A database error occurred. Please try again or contact support if the problem continues.';
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                $message = 'This record already exists. Please use a different value or check existing entries.';
            }

            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 422);
            }

            return redirect()->back()->withInput()->with('error', $message)->withErrors(['database' => $message]);
        }

        return parent::render($request, $e);
    }
}
