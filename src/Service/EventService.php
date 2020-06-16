<?php


namespace App\Service;


use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

class EventService
{
    protected $em;
    protected $paginator;
    private $_paginatorFirstPage;
    private $_paginatorEltByPage;

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
            $this->em->getRepository(Event::class)->getAllEvents(),
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