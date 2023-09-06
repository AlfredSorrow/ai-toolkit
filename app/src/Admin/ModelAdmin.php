<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Enum\ModelType;
use App\Form\DataMapper\ModelDataMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

final class ModelAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('code')
            ->add('name');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('code')
            ->add('name')
            ->add('type', EnumType::class, [
                'class' => ModelType::class,
            ])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('vendor')
            ->add('name')
            ->add('code')
            ->add('type', EnumType::class, [
                'class' => ModelType::class,
            ]);

        $builder = $form->getFormBuilder();
        $builder->setDataMapper(new ModelDataMapper());
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('code')
            ->add('name')
            ->add('type');
    }
}
