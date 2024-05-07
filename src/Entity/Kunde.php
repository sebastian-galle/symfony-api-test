<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'std.tbl_kunden')]
#[ApiResource(operations: [
        new GetCollection(uriTemplate: '/kunden'),
        new Post(uriTemplate: '/kunden'),
        new Get(uriTemplate: '/kunden/{id}'),
        new Put(uriTemplate: '/kunden/{id}'),
        new Delete(uriTemplate: '/kunden/{id}')
    ],
    normalizationContext: ['groups' => ['read'], "enable_max_depth" => true],
    denormalizationContext: ['groups' => ['write']]
)]
class Kunde
{
    #[
        ORM\Id,
        ORM\Column(type: 'string', unique: true, length: 36, columnDefinition: 'upper("left"((gen_random_uuid())::text, 8))'),
        ORM\GeneratedValue(strategy: "CUSTOM"),
        ORM\CustomIdGenerator(class: UuidGenerator::class)
    ]
    #[Groups(['read'])]
    private string $id;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Groups(['read', 'write'])]
    private string $name;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Groups(['read', 'write'])]
    private string $vorname;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Groups(['write'])]
    private string $firma;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Groups(['read', 'write'])]
    private DateTime $geburtsdatum;

    #[ORM\Column]
    #[Assert\NotNull]
    private int $geloescht = 0;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?string $geschlecht;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Groups(['read', 'write'])]
    private ?string $email;

    #[ORM\Column(name: "vermittler_id", type: "integer")]
    #[Assert\NotNull]
    #[Groups(['read', 'write'])]
    private int $vermittlerId;

    #[MaxDepth(1)]
    #[ORM\OneToOne(targetEntity: 'User', mappedBy: 'kunde')]
    #[Groups(['read'])]
    private ?User $user;

    #[MaxDepth(1)]
    #[Groups(['read', 'write'])]
    #[ORM\ManyToMany(targetEntity: "Adresse")]
    #[ORM\JoinTable(name: "std.kunde_adresse")]
    #[ORM\JoinColumn(name: "kunde_id", referencedColumnName: "id")]
    #[ORM\InverseJoinColumn(name: "adresse_id", referencedColumnName: "adresse_id")]
    private Collection $adressen;

    public function __construct()
    {
        $this->adressen = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getVorname(): string
    {
        return $this->vorname;
    }

    public function setVorname(string $vorname): void
    {
        $this->vorname = $vorname;
    }

    public function getFirma(): string
    {
        return $this->firma;
    }

    public function setFirma(string $firma): void
    {
        $this->firma = $firma;
    }

    public function getGeburtsdatum(): DateTime
    {
        return $this->geburtsdatum;
    }

    public function setGeburtsdatum(DateTime $geburtsdatum): void
    {
        $this->geburtsdatum = $geburtsdatum;
    }

    public function getGeloescht(): int
    {
        return $this->geloescht;
    }

    public function setGeloescht(int $geloescht): void
    {
        $this->geloescht = $geloescht;
    }

    public function getGeschlecht(): ?string
    {
        return $this->geschlecht;
    }

    public function setGeschlecht(?string $geschlecht): void
    {
        $this->geschlecht = $geschlecht;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getVermittlerId(): int
    {
        return $this->vermittlerId;
    }

    public function setVermittlerId(int $vermittlerId): void
    {
        $this->vermittlerId = $vermittlerId;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getAdressen(): Collection
    {
        return $this->adressen;
    }

    public function setAdressen(Collection $adressen): void
    {
        $this->adressen = $adressen;
    }

    public function addAdresse(Adresse $adresse): void
    {
        $this->adressen[] = $adresse;
    }
}
