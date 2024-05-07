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
#[ORM\Table(name: 'std.vermittler')]
#[ApiResource(operations: [
    new GetCollection(uriTemplate: '/vermittler'),
    new Post(uriTemplate: '/vermittler'),
    new Get(uriTemplate: '/vermittler/{id}'),
    new Put(uriTemplate: '/vermittler/{id}'),
    new Delete(uriTemplate: '/vermittler/{id}'),
],
    normalizationContext: ['groups' => ['read'], "enable_max_depth" => true],
    denormalizationContext: ['groups' => ['write']]
)]
class Vermittler
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private int $id;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Groups(['read', 'write'])]
    private string $nummer;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Groups(['read', 'write'])]
    private string $vorname;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Groups(['read', 'write'])]
    private string $nachname;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Groups(['read', 'write'])]
    private string $firma;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Groups(['write'])]
    private bool $geloescht = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNummer(): string
    {
        return $this->nummer;
    }

    public function setNummer(string $nummer): void
    {
        $this->nummer = $nummer;
    }

    public function getVorname(): string
    {
        return $this->vorname;
    }

    public function setVorname(string $vorname): void
    {
        $this->vorname = $vorname;
    }

    public function getNachname(): string
    {
        return $this->nachname;
    }

    public function setNachname(string $nachname): void
    {
        $this->nachname = $nachname;
    }

    public function getFirma(): string
    {
        return $this->firma;
    }

    public function setFirma(string $firma): void
    {
        $this->firma = $firma;
    }

    public function isGeloescht(): bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(bool $geloescht): void
    {
        $this->geloescht = $geloescht;
    }
}
