<?php
namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Kunde;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/foo')]
class CustomerController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private array $context;

    public function __construct(EntityManagerInterface $entityManager, ObjectNormalizerContextBuilder $builder)
    {
        $this->entityManager = $entityManager;
        $this->context = $builder
            ->withGroups('read')
            ->toArray();
    }

    #[Route('/kunden/{id}/user', name: 'user')]
    public function showUser(string $id, SerializerInterface $serializer): Response
    {
        /** @var Kunde $customer */
        $customer = $this->entityManager->getRepository(Kunde::class)->find($id);

        if (!$customer) {
            return new JsonResponse(['message' => 'Customer not found'], Response::HTTP_NOT_FOUND);
        }

        return new Response(
            $serializer->serialize($customer->getUser(), 'json', $this->context)
        );
    }

    #[Route('/kunden/{id}/adressen', name: 'customer_address_list')]
    public function showAddressList(string $id, SerializerInterface $serializer): Response
    {
        /** @var Kunde $customer */
        $customer = $this->entityManager->getRepository(Kunde::class)->find($id);

        if (!$customer) {
            return new JsonResponse(['message' => 'Customer not found'], Response::HTTP_NOT_FOUND);
        }

        return new Response(
            $serializer->serialize($customer->getAdressen(), 'json', $this->context)
        );
    }

    #[Route('/kunden/{id}/adressen/{addressId}/details', name: 'customer_address_details')]
    public function showAddress(string $id, int $addressId, SerializerInterface $serializer): Response
    {
        /** @var Adresse $address */
        $address = $this->entityManager->getRepository(Kunde::class)
            ->find($id)
            ->getAdressen()
            ->filter(fn($address) => $address->getId() === $addressId)
            ->first();

        if (!$address) {
            return new JsonResponse(['message' => 'Address not found'], Response::HTTP_NOT_FOUND);
        }

        return new Response(
            $serializer->serialize($address, 'json', $this->context)
        );
    }
}
