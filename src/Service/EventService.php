<?php


namespace App\Service;


use App\Entity\Event;
use App\Exception\PersistEventException;
use App\Repository\EventRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class EventService
{
    protected $eventRepository;
    protected $mfs;
    protected $translator;
    protected $paginator;

    private $_paginatorFirstPage;
    private $_paginatorEltByPage;

    /**
     * EventService constructor.
     * @param int $paginatorFirstPage
     * @param int $paginatorEltByPage
     * @param EventRepository $eventRepository
     * @param MessageFlashService $messageFlashService
     * @param TranslatorInterface $translator
     * @param PaginatorInterface $paginator
     */
    public function __construct(int $paginatorFirstPage, int $paginatorEltByPage, EventRepository $eventRepository, MessageFlashService $messageFlashService, TranslatorInterface $translator, PaginatorInterface $paginator)
    {
        $this->_paginatorFirstPage = $paginatorFirstPage;
        $this->_paginatorEltByPage = $paginatorEltByPage;
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
        if(!$event){
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
            $this->mfs->messageWarning($this->translator->trans("remove_event.msf.warning.begin") . " " . $id . " " . $this->translator->trans("remove_event.msf.warning.end"));
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


}