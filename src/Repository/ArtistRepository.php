<?php


namespace App\Repository;


use App\Entity\Artist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;

class ArtistRepository extends ServiceEntityRepository
{
    /**
     * ArtistRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artist::class);
    }

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

    /**
     * @param string $name
     * @return int|mixed|string
     */
    public function autoCompleteByName(string $name){
        $qb = $this->createQueryBuilder('a')
            ->select('a.name')
            ->where('upper(a.name) like :artistName')
            ->setParameter('artistName', strtoupper("%".$name."%"));

        return $qb->getQuery()->getArrayResult();
    }
}