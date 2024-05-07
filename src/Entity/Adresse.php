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
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'std.adresse')]
#[ApiResource(operations: [
    new GetCollection(uriTemplate: '/adressen'),
    new Post(uriTemplate: '/adressen'),
    new Get(uriTemplate: '/adressen/{id}'),
    new Put(uriTemplate: '/adressen/{id}'),
    new Delete(uriTemplate: '/adressen/{id}'),
],
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']]
)]
class Adresse
{
    #[ORM\Id, ORM\Column(name: 'adresse_id', type: 'integer'), ORM\GeneratedValue(strategy: "AUTO")]
    #[Groups(['read'])]
    private int $id;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Groups(['read', 'write'])]
    private string $strasse;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Groups(['read', 'write'])]
    private string $plz;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Groups(['read', 'write'])]
    private string $ort;

    #[ORM\ManyToOne(targetEntity: 'Bundesland')]
    #[ORM\JoinColumn(name:"bundesland", referencedColumnName:"kuerzel"), ]
    #[Groups(['read'])]
    private Bundesland $bundesland;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getStrasse(): string
    {
        return $this->strasse;
    }

    public function setStrasse(string $strasse): void
    {
        $this->strasse = $strasse;
    }

    public function getPlz(): string
    {
        return $this->plz;
    }

    public function setPlz(string $plz): void
    {
        $this->plz = $plz;
    }

    public function getOrt(): string
    {
        return $this->ort;
    }

    public function setOrt(string $ort): void
    {
        $this->ort = $ort;
    }

    public function getBundesland(): Bundesland
    {
        return $this->bundesland;
    }

    public function setBundesland(Bundesland $bundesland): void
    {
        $this->bundesland = $bundesland;
    }
}
