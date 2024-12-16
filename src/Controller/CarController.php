<?php

namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car')]
    public function index(EntityManagerInterface $em): Response
    {
        $car = new Car();
        $car->setBrand('Audi');
        $car->setColor('rood');
        $car->setBuildyear(2000);
        $car->setName('Audi A3');

        $em->persist($car);
        $em->flush();

        return $this->render('car/index.html.twig', [
            'controller_name' => 'CarController',
        ]);
    }

    #[Route('/car/viewall', name: 'app_car_viewall')]
    public function viewall(CarRepository $carRepository): Response
    {
        $cars = $carRepository->findAll();

        foreach ($cars as $car) {
            //echo $car->getColor();
            //echo '<br>';
        }

        return new JsonResponse($cars);
    }

    #[Route('/car/view/{id}', name: 'app_car_view')]
    public function view(CarRepository $carRepository, string $id): Response
    {
        $car = $carRepository->find($id);

        return new JsonResponse($car);
    }
}