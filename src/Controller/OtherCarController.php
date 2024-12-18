<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\Car2Type;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/other/car')]
final class OtherCarController extends AbstractController
{
    #[Route(name: 'app_other_car_index', methods: ['GET'])]
    public function index(CarRepository $carRepository): Response
    {
        return $this->render('other_car/index.html.twig', [
            'cars' => $carRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_other_car_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $car = new Car();
        $form = $this->createForm(Car2Type::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('app_other_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('other_car/new.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_other_car_show', methods: ['GET'])]
    public function show(Car $car): Response
    {
        return $this->render('other_car/show.html.twig', [
            'car' => $car,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_other_car_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Car $car, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Car2Type::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_other_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('other_car/edit.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_other_car_delete', methods: ['POST'])]
    public function delete(Request $request, Car $car, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($car);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_other_car_index', [], Response::HTTP_SEE_OTHER);
    }
}
