<?php


namespace App\Service;


use App\Entity\Event;
use App\Repository\EventRepository;
use Knp\Component\Pager\PaginatorInterface;

class EventService
{
    protected $eventRepository;
    protected $paginator;
    private $_paginatorFirstPage;
    private $_paginatorEltByPage;

    /**
     * EventService constructor.
     * @param int $paginatorFirstPage
     * @param int $paginatorEltByPage
     * @param EventRepository $eventRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(int $paginatorFirstPage, int $paginatorEltByPage, EventRepository $eventRepository, PaginatorInterface $paginator)
    {
        $this->_paginatorFirstPage = $paginatorFirstPage;
        $this->_paginatorEltByPage = $paginatorEltByPage;
        $this->eventRepository = $eventRepository;
        $this->paginator = $paginator;
    }

    /**
     * Persist entity Event
     *
     * @param Event $event
     */
    public function save(Event $event)
    {
        $this->eventRepository->saveEvent($event);
    }

    /**
     * @param int $id
     * @return int 1 if deleted 0 if not exist
     */
    public function delete(int $id)
    {
        return $this->em->getRepository(Event::class)->removeEvent($id);
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