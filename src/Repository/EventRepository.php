<?php


namespace App\Repository;


use App\Entity\Event;
use App\Entity\EventFilter;
use App\Exception\PersistEventException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\TransactionRequiredException;
use phpDocumentor\Reflection\Types\Integer;


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
    public function saveEvent(Event $event)
    {
        try {
            $this->getEntityManager()->persist($event);
            $this->getEntityManager()->flush();
        } catch (ORMException $e) {
            throw new PersistEventException($e->getMessage());
        }
    }

    public function getFilteredEvents(EventFilter $eventFilter)
    {
        $qb = $this->createQueryBuilder('fe')
            ->addSelect('fe')
            ->join('fe.artist', 'artiste')
            ->addSelect('artiste')
            ->join('fe.city', 'city')
            ->addSelect('city');

        if (null !== $eventFilter->getFromDate()) {

            $qb->andWhere('fe.date >= :dateFrom');

            $qb->setParameter('dateFrom', $eventFilter->getFromDate()->format("Y-m-d"));

        }
        if (null !== $eventFilter->getToDate()) {

            $qb->andWhere('fe.date <= :dateTo');

            $qb->setParameter('dateTo', $eventFilter->getToDate()->format("Y-m-d"));

        }
        if (null !== $eventFilter->getArtist() && !empty(trim($eventFilter->getArtist()))) {
            $qb->andWhere('UPPER(artiste.name) = :artistName')
                ->setParameter('artistName', strtoupper($eventFilter->getArtist()));
        }
        if (null !== $eventFilter->getCity() && 0 !== $eventFilter->getCity()) {
            $qb->andWhere('city.id = :cityId')
                ->setParameter('cityId', $eventFilter->getCity());
        }

        $qb->orderBy('fe.date', 'ASC')
        ->addOrderBy('artiste.name', 'ASC');

        return $qb->getQuery()->getResult();
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
     * @param Integer $id
     * @return int|mixed|string
     */
    public function findOneByIdWithJoins(int $id)
    {
        $qb = $this->createQueryBuilder('e')
            ->addSelect('e')
            ->join('e.artist', 'artiste')
            ->addSelect('artiste')
            ->join('e.city', 'city')
            ->addSelect('city')
            ->where('e.id = :id')
            ->setParameter('id', $id);
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

    public function updateEvent(Event $event)
    {
        $retour = true;

        try {
            $em = $this->getEntityManager();
            $eventDB = $em->find(Event::class, $event->getId());
            if (!$eventDB) {
                $retour = false;
            } else {
                $eventDB->setDate($event->getDate());
                $eventDB->setCity($event->getCity());
                $eventDB->setArtist($event->getArtist());

                $em->flush();
            }

        } catch (OptimisticLockException $e) {
        } catch (TransactionRequiredException $e) {
        } catch (ORMException $e) {
            $retour = false;
        }

        return $retour;
    }
}