<?php

declare(strict_types=1);

namespace App\Entity\Interface;

use Symfony\Component\Security\Core\User\UserInterface;

interface OwnedEnitityInterface extends EntityInterface
{
    public function getUser(): UserInterface;
}
