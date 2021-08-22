<?php

    namespace udp2\Exceptions;

    use Exception;
    use Throwable;

    class FileUploadException extends Exception
    {
        /**
         * @var Throwable|null
         */
        private $previous;

        /**
         * @param string $message
         * @param int $code
         * @param Throwable|null $previous
         */
        public function __construct($message = "", $code = 0, Throwable $previous = null)
        {
            parent::__construct($message, $code, $previous);
            $this->message = $message;
            $this->code = $code;
            $this->previous = $previous;
        }
    }