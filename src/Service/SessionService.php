<?php


namespace App\Service;


use App\Entity\Artist;
use App\Entity\City;
use App\Entity\Event;
use App\Exception\EventSessionException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class SessionService
{

    protected $session;
    protected $translator;

    const EVENT = "event";

    /**
     * DateService constructor.
     * @param SessionInterface $session
     * @param TranslatorInterface $translator
     */
    public function __construct(SessionInterface $session, TranslatorInterface $translator)
    {
        $this->session = $session;
        $this->translator = $translator;
    }

    /**
     * @return mixed
     */
    public function getOrCreateEventSession(){
        if(! $this->session->has(self::EVENT) ||
            $this->session->get(self::EVENT) === null){

            $this->saveEventToSession(new Event());
        }
        return $this->session->get(self::EVENT);
    }

    /**
     * @return mixed
     * @throws EventSessionException
     */
    public function getEventSession(){
        if(! $this->session->has(self::EVENT) ||
            $this->session->get(self::EVENT) === null ){

            throw new EventSessionException($this->translator->trans('service.session.event.exception'));
        }
        return $this->session->get(self::EVENT);
    }

    /**
     * @param Event $event
     */
    public function saveEventToSession(Event $event){
        $this->session->set(self::EVENT, $event);
    }

    /**
     * remove Event from session
     */
    public function deleteEventFromSession(){
        $this->session->remove(self::EVENT);
    }
}