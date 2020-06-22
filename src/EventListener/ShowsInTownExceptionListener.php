<?php


namespace App\EventListener;



use App\Exception\GlobalSITException;
use App\Exception\PersistEventException;
use App\Exception\SessionException;
use App\Service\MessageFlashService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Routing\RouterInterface;

class ShowsInTownExceptionListener
{
    private $_router;
    private $_mfs;

    /**
     * CBRExceptionListener constructor.
     * @param RouterInterface $router
     * @param MessageFlashService $mfs
     */
    public function __construct(RouterInterface $router, MessageFlashService $mfs)
    {
        $this->_router = $router;
        $this->_mfs = $mfs;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getThrowable();

        if ($exception instanceof GlobalSITException) {
            $event->setResponse($this->catchException($exception->getPath(), $exception->getMessage()));
        } else {
            return false;
        }
    }

    /**
     * @param $route
     * @param null $message
     * @return RedirectResponse
     */
    private function catchException($route, $message = null)
    {
        if ($message !== null) {
            $this->_mfs->messageError($message);
        }
        return new RedirectResponse($this->_router->generate($route));
    }
}