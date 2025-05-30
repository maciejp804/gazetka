<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\View\ViewException;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    protected $dontReport = [];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            if ($e instanceof ViewException) {
                Log::error('Błąd ViewException', [
                    'message' => $e->getMessage(),
                    'url' => request()->fullUrl(),
                    'referer' => request()->headers->get('referer'),
                ]);
            }
        });
    }
}
