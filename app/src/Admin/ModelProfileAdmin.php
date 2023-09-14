<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\User;
use App\Entity\VendorSetting;
use App\Form\DataMapper\ModelProfileDataMapper;
use App\Form\OpenAiChatProfileType;
use App\Repository\ModelRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ModelProfileAdmin extends AbstractAdmin
{
    public function __construct(
        private readonly TokenStorageInterface $tokenStorage,
        private readonly ModelRepository $modelRepository
    ) {
        parent::__construct();
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
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
        $this->restrictIfNotAllowed();

        $form
            ->add('name')
            ->add('model', ChoiceFieldMaskType::class, ['choices' => $this->getChoices()])
            ->add('setting', OpenAiChatProfileType::class);

        /** @var User */
        $currentUser = $this->tokenStorage->getToken()->getUser();
        $builder = $form->getFormBuilder();
        $builder->setDataMapper(new ModelProfileDataMapper($currentUser, $this->modelRepository));
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $this->restrictIfNotAllowed();
        $show
            ->add('id')
            ->add('createdAt')
            ->add('updatedAt');
    }

    private function restrictIfNotAllowed(): void
    {
        /** @var VendorSetting $vendorSetting */
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
        /** @var ProxyQuery $query */
        $query = parent::configureQuery($query);

        $rootAlias = current($query->getRootAliases());
        $currentUser = $this->tokenStorage->getToken()->getUser();

        $query->andWhere(
            $query->expr()->eq($rootAlias.'.user', ':user')
        );
        $query->setParameter('user', $currentUser);

        return $query;
    }

    /**
     * @return array<string, int>
     */
    private function getChoices(): array
    {
        $models = $this->modelRepository->findEnabled();
        $choices = [];
        foreach ($models as $model) {
            $choices[$model->getName()] = $model->getId();
        }

        return $choices;
    }
}
