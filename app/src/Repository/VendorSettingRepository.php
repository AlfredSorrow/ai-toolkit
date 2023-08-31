<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\VendorSetting;

/**
 * @extends AbstractEntityRepository<VendorSetting>
 *
 * @method VendorSetting|null find($id, $lockMode = null, $lockVersion = null)
 * @method VendorSetting|null findOneBy(array $criteria, array $orderBy = null)
 * @method VendorSetting[]    findAll()
 * @method VendorSetting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VendorSettingRepository extends AbstractEntityRepository
{
    protected function getEntityClass(): string
    {
        return VendorSetting::class;
    }
}
