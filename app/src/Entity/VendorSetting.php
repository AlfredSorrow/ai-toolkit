<?php

declare(strict_types=1);

namespace App\Entity;

use App\Encryption\Crypto;
use App\Entity\Interface\OwnedEnitityInterface;
use App\Entity\ValueObject\Token;
use App\Repository\VendorSettingRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VendorSettingRepository::class)]
class VendorSetting implements OwnedEnitityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'userVendorSettings')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    /**
     * @var array<mixed>
     */
    #[ORM\Column]
    private array $setting = [];

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Vendor $vendor;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    #[ORM\Column]
    private DateTimeImmutable $updatedAt;

    public function __construct(User $user, Vendor $vendor, Token $setting)
    {
        $this->user = $user;
        $this->vendor = $vendor;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->updateSetting($setting);
    }

    public function updateSetting(Token $setting): void
    {
        $setting = Crypto::encryptArray(['token' => $setting->getToken()]);
        $this->setting = $setting;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function hasId(): bool
    {
        return isset($this->id);
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getSetting(): Token
    {
        $setting = Crypto::decryptArray($this->setting);

        return new Token($setting['token']);
    }

    public function getVendor(): Vendor
    {
        return $this->vendor;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
