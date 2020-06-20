<?php


namespace App\Repository;


use App\Entity\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


class CityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, City::class);
    }



    /**
     * @param string $name
     * @return int|mixed|string
     */
    public function findOneByName(string $name){
        $qb = $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.name = :cityName')
            ->setParameter('cityName', $name);
        return $qb->getQuery()->getResult();
    }
}