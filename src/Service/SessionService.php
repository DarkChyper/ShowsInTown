<?php


namespace App\Service;


use App\Entity\Event;
use App\Entity\EventFilter;
use App\Exception\EventSessionException;
use App\Exception\SessionException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class SessionService
{

    const EVENT = "event";
    const FILTER = "filter";
    const PATH_HOMEPAGE = "homepage";
    const PATH_DASHBOARD = "dashboard";
    protected $session;
    protected $translator;

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
    public function getOrCreateEventSession()
    {
        if (!$this->session->has(self::EVENT) ||
            $this->session->get(self::EVENT) === null) {

            $this->saveEventToSession(new Event());
        }
        return $this->getEventSession();
    }

    /**
     * @param Event $event
     */
    public function saveEventToSession(Event $event)
    {
        $this->session->set(self::EVENT, $event);
    }

    /**
     * @return mixed
     * @throws SessionException
     */
    public function getEventSession()
    {
        if (!$this->session->has(self::EVENT) ||
            $this->session->get(self::EVENT) === null) {

            throw new SessionException(self::PATH_DASHBOARD, $this->translator->trans('service.session.event.exception'));
        }
        return $this->session->get(self::EVENT);
    }

    /**
     * @return EventFilter
     */
    public function getOrCreateEventFilterSession()
    {
        if (!$this->session->has(self::FILTER) ||
            $this->session->get(self::FILTER) === null) {
            $this->saveEventFilterToSession(new EventFilter());
        }

        return $this->getEventFilterSession();
    }

    /**
     * @param EventFilter $filter
     */
    public function saveEventFilterToSession(EventFilter $filter)
    {
        $this->session->set(self::FILTER, $filter);
    }

    /**
     * @return EventFilter
     * @throws SessionException
     */
    public function getEventFilterSession()
    {
        if (!$this->session->has(self::FILTER) ||
            $this->session->get(self::FILTER) === null) {

            throw new SessionException(self::PATH_HOMEPAGE, $this->translator->trans('service.session.filter.exception'));
        }
        return $this->session->get(self::FILTER);
    }

    /**
     * remove Event from session
     */
    public function deleteEventFromSession()
    {
        $this->session->remove(self::EVENT);
    }

    /**
     * remove EventFilter from session
     */
    public function deleteEventFilterFromSession()
    {
        $this->session->remove(self::FILTER);
    }
}