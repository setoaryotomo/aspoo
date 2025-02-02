<?php

namespace App\Exceptions;

use App\Handler\JsonResponseHandler;
use App\Type\JsonResponseType;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

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
        $this->reportable(function (Throwable $e) {
        });
        $this->renderable(function (ValidationException $e) {
            $errors = $e->errors();
            $messages = [];
            foreach($errors as $key => $error) {
                foreach($error as $key => $message) {
                    array_push($messages, $message);
                }
            }
            return JsonResponseHandler::setResult($errors)
                ->setCode(JsonResponseType::VALIDATION_ERROR)
                ->setMessage(join(", ", $messages))
                ->setStatus(422)
                ->send();
        });
        $this->renderable(function (AppException $e) {
            $errors = $e->errors;
            return JsonResponseHandler::setResult($errors)
                ->setCode($e->code)
                ->setMessage($e->message)
                ->setStatus($e->httpCode)
                ->send();
        });
        $this->renderable(function (Exception $e) {
            return JsonResponseHandler::setResult([])
                ->setCode(JsonResponseType::INTERNAL_SERVER_ERROR)
                ->setMessage($e->getMessage())
                ->setStatus(500)
                ->send();
        });
        
    }
}
