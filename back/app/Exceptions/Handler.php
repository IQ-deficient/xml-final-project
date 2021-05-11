<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    // REDIRECT ON NON-EXISTENT ROUTE
    public function render($request, Throwable $e)
    {
        if ($this->isHttpException($e)) {
            if ($e->getStatusCode() == 404)
                return redirect()->guest('login');

            if ($e->getStatusCode() == 500)
                return redirect()->guest('login');
        }
        return parent::render($request, $e);
    }
//    {
//        if ($this->isHttpException($e)) {
//            switch ($e->getStatusCode()) {
//                // not found
//                case 404:
//                    return redirect()->guest('login');
//                    break;
//
//                // internal error
//                case '500':
//                    return redirect()->guest('dashboard');
//                    break;
//
//                default:
//                    return $this->renderHttpException($e);
//                    break;
//            }
//        } else {
//            return parent::render($request, $e);
//        }
//    }

}
