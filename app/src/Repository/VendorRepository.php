<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Vendor;

/**
 * @extends AbstractEntityRepository<Vendor>
 *
 * @method Vendor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vendor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vendor[]    findAll()
 * @method Vendor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VendorRepository extends AbstractEntityRepository
{
    protected function getEntityClass(): string
    {
        return Vendor::class;
    }

    public function getVendor(string $id): Vendor
    {
        $vendor = $this->find($id);

        return $vendor;
    }
}
