<?php
namespace App\Exceptions\ShivEnigma;


abstract class BaseException extends \Exception
{
    protected $errors;

    public function __construct($errors = null, $messages = null, $code = 0, \Exception $previous = null)
    {
        $this->setErrors($errors);
        parent::__construct($messages, $code, $previous);
    }

    protected function setErrors($errors)
    {
        if (is_string($errors)) {
            $errors = array($errors);
        }
        if (is_array($errors)) {
            $errors = $errors;
        }
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
