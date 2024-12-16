<?php

namespace App\Controller;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car')]
    public function index(EntityManagerInterface $em): Response
    {
        $car = new Car();
        $car->setBrand('Audi');
        $car->setColor('geel');
        $car->setBuildyear(2000);
        $car->setName('Audi A3');

        $em->persist($car);
        $em->flush();

        return $this->render('car/index.html.twig', [
            'controller_name' => 'CarController',
        ]);
    }
}
