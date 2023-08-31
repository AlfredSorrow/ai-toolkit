<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AppSetting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppSetting>
 *
 * @method AppSetting|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppSetting|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppSetting[]    findAll()
 * @method AppSetting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppSettingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppSetting::class);
    }
}
