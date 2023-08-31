<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\EntityInterface;
use App\Repository\VendorRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VendorRepository::class)]
class Vendor implements EntityInterface
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column(type: Types::TEXT)]
    private string $description = '';

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function __toString()
    {
        return $this->getId();
    }

    public function hasId(): bool
    {
        return isset($this->id);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
