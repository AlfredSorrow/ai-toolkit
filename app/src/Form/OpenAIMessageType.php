<?php

declare(strict_types=1);

namespace App\Form;

use App\Integration\OpenAI\ValueObject\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class OpenAIMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('role', ChoiceType::class, [
                'choices' => array_combine(Message::ROLES, Message::ROLES),
                'help' => 'Initial messages to OpenAI chat. You can assign behavior to chat with System role',
            ])
            ->add('content', TextType::class)
        ;
    }
}
