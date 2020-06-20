<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MessageFlashService
{
    protected $session;
    const SUCCESS = "success";
    const WARNING = "warning";
    const ERROR = "danger";
    const INFO = "info";

    /**
     * Contructor
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @param String $message
     */
    public function messageSuccess($message){
        $this->addMessage($message,self::SUCCESS);
    }

    /**
     * @param String $message
     */
    public function messageWarning($message){
        $this->addMessage($message,self::WARNING);
    }

    /**
     * @param String $message
     */
    public function messageError($message){
        $this->addMessage($message,self::ERROR);
    }

    /**
     * @param String $message
     */
    public function messageInfo($message){
        $this->addMessage($message,self::INFO);
    }

    /**
     * Add $message in session FlashBag system with $label
     *
     * @param String $message
     * @param String $label
     */
    private function addMessage($message, $label) {
        $this->session->getFlashBag()->add($label, $message);
    }
}