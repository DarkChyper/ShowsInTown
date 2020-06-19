<?php


namespace App\Repository;


use App\Entity\Event;
use App\Exception\PersistEventException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;


class EventRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * Persist Event in db
     * @param Event $event
     * @throws PersistEventException
     */
    public function saveEvent(Event $event){
        try {
            $this->getEntityManager()->persist($event);
            $this->getEntityManager()->flush();
        } catch (ORMException $e) {
            throw new PersistEventException($e->getMessage());
        }
    }

    /**
     * @return array|int|string
     */
    public function getAllEvents()
    {
        $qb = $this->createQueryBuilder('e')
            ->addSelect('e')
            ->join('e.artist', 'artiste')
            ->addSelect('artiste')
            ->join('e.city', 'city')
            ->addSelect('city')
            ->orderBy('e.date', 'ASC')
            ->addOrderBy('artiste.name', 'ASC');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param int $id
     * @return int|mixed|string
     */
    public function removeEvent(int $id)
    {
        $qb = $this->createQueryBuilder('e')
            ->delete('App:Event', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->execute();
    }
}