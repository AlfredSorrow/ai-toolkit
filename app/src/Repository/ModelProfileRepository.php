<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ModelProfile;

/**
 * @extends AbstractEntityRepository<ModelProfile>
 *
 * @method ModelProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModelProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModelProfile[]    findAll()
 * @method ModelProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelProfileRepository extends AbstractEntityRepository
{
    protected function getEntityClass(): string
    {
        return ModelProfile::class;
    }
}
