<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(operations: [
    new GetCollection(uriTemplate: '/bundeslaender'),
    new Post(uriTemplate: '/bundeslaender'),
])]
#[ORM\Entity]
#[ORM\Table(name: 'public.bundesland')]
#[ApiResource(operations: [
    new GetCollection(uriTemplate: '/bundeslaender'),
    new Post(uriTemplate: '/bundeslaender'),
],
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']]
)]
class Bundesland
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    #[Groups(['read'])]
    private string $kuerzel;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Groups(['read', 'write'])]
    private ?string $name;

    public function getKuerzel(): string
    {
        return $this->kuerzel;
    }

    public function setKuerzel(string $kuerzel): void
    {
        $this->kuerzel = $kuerzel;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
