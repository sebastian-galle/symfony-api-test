<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'sec.user')]
#[ApiResource(operations: [
    new GetCollection(uriTemplate: '/user'),
    new Post(uriTemplate: '/user'),
    new Get(uriTemplate: '/user/{id}'),
    new Put(uriTemplate: '/user/{id}'),
    new Delete(uriTemplate: '/user/{id}')
],
    normalizationContext: ['groups' => ['read'], "enable_max_depth" => true],
    denormalizationContext: ['groups' => ['write']],
)]
class User
{
    #[ORM\Id, ORM\Column(type: 'integer'), ORM\GeneratedValue(strategy: "IDENTITY")]
    #[Groups(['read'])]
    private int $id;

    #[ORM\Column(name:"email", type:"string", length:200, nullable:false)]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Groups(['read', 'write'])]
    private string $email;

    #[ORM\Column(name:"passwd", type:"string", length:80, nullable:false)]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(['min' => 8])]
    #[Assert\Regex(['pattern' => '/\d+/'])]
    #[Assert\Regex(['pattern' => '/[a-z]+/'])]
    #[Assert\Regex(['pattern' => '/[A-Z]+/'])]
    #[Assert\Regex(['pattern' => '/[#?!@$%^&*-_]+/'])]
    #[Groups(['write'])]
    private string $passwd;

    #[ORM\Column(name:"aktiv", type:"integer", nullable:false)]
    #[Assert\NotNull]
    #[Groups(['read', 'write'])]
    private int $aktiv;

    #[ORM\Column(name:"last_login", type:"datetime", nullable:true)]
    #[Groups(['read'])]
    private ?\DateTime $lastLogin;

    #[MaxDepth(1)]
    #[ORM\OneToOne(targetEntity: "Kunde", inversedBy: 'user')]
    #[ORM\JoinColumn(name:"kundenid", referencedColumnName:"id")]
    private Kunde $kunde;

    #[ORM\Column(name:"kundenid", type:"string", nullable:true)]
    #[Assert\NotBlank]
    #[Groups(['write'])]
    private ?string $kundenid;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPasswd(): string
    {
        return $this->passwd;
    }

    public function setPasswd(string $passwd): void
    {
        $this->passwd = $passwd;
    }

    public function getAktiv(): int
    {
        return $this->aktiv;
    }

    public function setAktiv(int $aktiv): void
    {
        $this->aktiv = $aktiv;
    }

    public function getLastLogin(): ?\DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTime $lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }

    public function getKunde(): Kunde
    {
        return $this->kunde;
    }

    public function setKunde(Kunde $kunde): void
    {
        $this->kunde = $kunde;
        $this->setKundenid($kunde->getId());
    }

    public function getKundenid(): ?string
    {
        return $this->kundenid;
    }

    public function setKundenid(?string $kundenid): void
    {
        $this->kundenid = $kundenid;
    }
}
