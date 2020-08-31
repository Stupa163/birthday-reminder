<?php

namespace App\Repository;

use App\Entity\Friend;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Friend|null find($id, $lockMode = null, $lockVersion = null)
 * @method Friend|null findOneBy(array $criteria, array $orderBy = null)
 * @method Friend[]    findAll()
 * @method Friend[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FriendRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Friend::class);
    }

    /**
     * @return array|Friend[]
     */
    public function findBirthdaysOfTheDay(): array
    {
        $q = $this->createQueryBuilder('f');
        $q->where($q->expr()->eq(
            'DATE_FORMAT(f.birthdayDate, \'%d-%m\')',
            ("'" . (new DateTime())->format('d-m') ."'")
        ));

        return $q->getQuery()->getResult();
    }
}
