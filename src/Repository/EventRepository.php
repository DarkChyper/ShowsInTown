<?php


namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class EventRepository extends EntityRepository
{
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