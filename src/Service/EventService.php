<?php


namespace App\Service;


use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

class EventService
{
    private $_paginatorFirstPage;
    private $_paginatorEltByPage;
    protected $em;
    protected $paginator;

    /**
     * EventService constructor.
     * @param int $paginatorFirstPage
     * @param int $paginatorEltByPage
     * @param EntityManagerInterface $entityManager
     * @param PaginatorInterface $paginator
     */
    public function __construct(int $paginatorFirstPage, int $paginatorEltByPage, EntityManagerInterface $entityManager, PaginatorInterface $paginator)
    {
        $this->_paginatorFirstPage = $paginatorFirstPage;
        $this->_paginatorEltByPage = $paginatorEltByPage;
        $this->em = $entityManager;
        $this->paginator = $paginator;
    }

    /**
     * Persist entity Event
     *
     * @param Event $event
     */
    public function save(Event $event)
    {
        $this->em->persist($event);
        $this->em->flush();
    }


    /**
     * @param $page Number by offset $limit
     * @param $limit Number of unit by page
     * @return object[]
     */
    public function getAllEventByPage($page, $limit)
    {

        $pagination = $this->paginator->paginate(
            $this->em->getRepository(Event::class)->getAllEvents(),
            $page,
            $limit
        );
        $pagination->setTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig');
        return $pagination;
    }


}