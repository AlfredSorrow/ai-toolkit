<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\User;
use App\Entity\VendorSetting;
use App\Form\DataMapper\VendorSettingDataMapper;
use App\Form\OpenAIFormType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final class VendorSettingAdmin extends AbstractAdmin
{
    public function __construct(private TokenStorageInterface $tokenStorage)
    {
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('vendor');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('vendor')
            ->add('createdAt')
            ->add('updatedAt')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $isEntityCreated = $this->getSubject()->hasId();

        $this->restrictIfNotAllowed();

        $form
            ->add('vendor', null, [
                'disabled' => $isEntityCreated,
            ])
            ->add('setting', OpenAIFormType::class);

        /** @var User */
        $currentUser = $this->tokenStorage->getToken()->getUser();
        $builder = $form->getFormBuilder();
        $builder->setDataMapper(new VendorSettingDataMapper($currentUser));
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $this->restrictIfNotAllowed();
        $show
            ->add('id')
            ->add('setting')
            ->add('vendor')
            ->add('createdAt')
            ->add('updatedAt');
    }

    private function restrictIfNotAllowed(): void
    {
        /** @var VendorSetting */
        $vendorSetting = $this->getSubject();
        $currentUser = $this->tokenStorage->getToken()->getUser();

        if ($vendorSetting->hasId()) {
            if ($vendorSetting->getUser() !== $currentUser) {
                throw new AccessDeniedException('Not allowed.');
            }
        }
    }

    protected function configureQuery(ProxyQueryInterface $query): ProxyQueryInterface
    {
        /** @var ProxyQuery */
        $query = parent::configureQuery($query);

        $rootAlias = current($query->getRootAliases());
        $currentUser = $this->tokenStorage->getToken()->getUser();

        $query->andWhere(
            $query->expr()->eq($rootAlias.'.user', ':user')
        );
        $query->setParameter('user', $currentUser);

        return $query;
    }
}
