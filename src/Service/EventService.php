<?php


namespace App\Service;


use App\Entity\Event;
use App\Entity\EventFilter;
use App\Exception\PersistEventException;
use App\Repository\EventRepository;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use Symfony\Contracts\Translation\TranslatorInterface;

class EventService
{
    const INTERVAL_TIME = "P3M";
    protected $translator;
    protected $paginator;
    protected $eventRepository;
    protected $mfs;

    /**
     * EventService constructor.
     * @param TranslatorInterface $translator
     * @param PaginatorInterface $paginator
     * @param EventRepository $eventRepository
     * @param MessageFlashService $messageFlashService
     */
    public function __construct(
        TranslatorInterface $translator,
        PaginatorInterface $paginator,
        EventRepository $eventRepository,
        MessageFlashService $messageFlashService
    )
    {
        $this->eventRepository = $eventRepository;
        $this->mfs = $messageFlashService;
        $this->translator = $translator;
        $this->paginator = $paginator;
    }

    /**
     * Persist entity Event
     *
     * @param Event $event
     * @throws PersistEventException
     */
    public function save(Event $event)
    {
        if ($event->getCityChoice() > 0) {
            if (!$this->eventRepository->updateEvent($event)) {
                throw new PersistEventException($this->translator->trans("edit_event.msf.error", ['{{id}}' => $event->getId()]));
            }
        } else {
            $this->eventRepository->saveEvent($event);
        }
        $this->mfs->messageSuccess($this->translator->trans("edit_event.msf.success"));

    }

    /**
     * @param $id
     * @return object
     * @throws PersistEventException
     */
    public function getEvent($id)
    {
        $event = $this->eventRepository->findOneBy(["id" => $id]);
        if (!$event) {
            throw new PersistEventException($this->translator->trans("edit_event.msf.error", ['{{id}}' => $id]));
        }
        return $event;
    }

    /**
     * Delete event by id
     * @param int $id
     */
    public function delete(int $id)
    {
        $result = $this->eventRepository->removeEvent($id);
        if ($result === 1) {
            $this->mfs->messageSuccess($this->translator->trans("remove_event.msf.success"));
        } else {
            $this->mfs->messageWarning($this->translator->trans("edit_event.msf.error", ["{{id}}" => $id]));
        }
    }


    /**
     * @param $page Number by offset $limit
     * @param $limit Number of unit by page
     * @return object[]
     */
    public function getAllEventByPage($page, $limit)
    {

        $pagination = $this->paginator->paginate(
            $this->eventRepository->getAllEvents(),
            $page,
            $limit
        );
        $pagination->setTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig');
        $pagination->setSortableTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_filtration.html.twig');
        $pagination->setCustomParameters([
            'align' => 'center'
        ]);
        return $pagination;
    }

    public function getFilteredEvents(EventFilter $eventFilter)
    {
        if($eventFilter->isEmpty()){
            return $this->eventRepository->getFilteredEvents($this->getDefaultEventFilter());
        }
        return $this->eventRepository->getFilteredEvents($eventFilter);
    }

    public function getDefaultEventFilter()
    {
        $eventFilter = new EventFilter();
        $eventFilter->setFromDate(new DateTime());
        try {
            // l'interval pourrait être un paramètre d'application
            $now = new DateTime();
            $interval = new \DateInterval(self::INTERVAL_TIME);
            $eventFilter->setToDate($now->add($interval));
        } catch (\Exception $e) {
            // si le dateInterval est faux  on prend la date du jour
            $eventFilter->setToDate(new DateTime());
        }

        return $eventFilter;
    }


}