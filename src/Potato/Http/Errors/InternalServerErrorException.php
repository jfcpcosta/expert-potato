<?php namespace Potato\Http\Errors;

class InternalServerErrorException extends HttpException {

    public function __construct(string $message = 'Internal server error') {
        parent::__construct($message, 500);
    }
}