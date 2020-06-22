<?php


namespace App\Exception;




use Throwable;

class GlobalSITException extends \RuntimeException
{

    protected $path;

    /**
     * SessionException constructor.
     * @param $path
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($path,$message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path): void
    {
        $this->path = $path;
    }




}