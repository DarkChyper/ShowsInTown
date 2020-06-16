<?php


namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class ArtistRepository extends EntityRepository
{

    /**
     * @param string $name
     * @return int|mixed|string
     */
    public function findOneByName(string $name){
        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.name = :artistName')
            ->setParameter('artistName', $name);
        return $qb->getQuery()->getResult();
    }
}