<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Enum\ModelStatus;
use App\Entity\Model;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends AbstractEntityRepository<Model>
 *
 * @method Model|null find($id, $lockMode = null, $lockVersion = null)
 * @method Model|null findOneBy(array $criteria, array $orderBy = null)
 * @method Model[]    findAll()
 * @method Model[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelRepository extends AbstractEntityRepository
{
    protected function getEntityClass(): string
    {
        return Model::class;
    }

    /**
     * @return Paginator<Model>
     */
    public function findEnabled(): Paginator
    {
        return $this->createPaginator(
            $this->createQueryBuilder('m')
                ->where('m.status = :status')
            ->setParameter('status', ModelStatus::Enabled)
        );
    }
}
