<?php

declare(strict_types=1);

namespace App\Form;

use Sonata\AdminBundle\Form\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class OpenAiChatProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('messages', CollectionType::class, [
                'entry_type' => OpenAIMessageType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('presencePenalty', IntegerType::class, [
                'required' => false,
            ])
            ->add('frequencyPenalty', IntegerType::class, [
                'required' => false,
            ])
        ;
    }
}
