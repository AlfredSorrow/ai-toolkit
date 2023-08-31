<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interface\EntityInterface;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['usernameCanonical'], message: 'There is already an account with this username')]
#[UniqueEntity(fields: ['emailCanonical'], message: 'There is already an account with this email')]
class User extends BaseUser implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected $id;

    /**
     * Collection<int, VendorSetting>.
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: VendorSetting::class, orphanRemoval: true)]
    private Collection $userVendorSettings;

    public function __construct()
    {
        $this->userVendorSettings = new ArrayCollection();
    }

    public function getId(): int|string|null
    {
        return $this->id;
    }

    public function hasId(): bool
    {
        return isset($this->id);
    }

    /**
     * @return Collection<int, VendorSetting>
     */
    public function getVendorSettings(): Collection
    {
        return $this->userVendorSettings;
    }
}
