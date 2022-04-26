<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route({"en":"/cars","es":"/autos"}, name="car_service_cars_")
 */
class CarController extends AbstractController
{
    /**
     * @Route({"en":"/index","es":"/indice"}, name="index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, CarRepository $carRepository): Response
    {
        $limit = 10;

        $paginatorOptions =
        [
            'defaultSortFieldName' => 'car.description',
            'defaultSortDirection' => 'asc'
        ];

        $pagination = $paginator->paginate(
            $carRepository->index(),
            $request->query->getInt('page', 1)      /*page number*/,
            $limit                                  /*limit per page*/,
            $paginatorOptions
       );        

        return $this->render('@Cars/car/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route({"en":"/new","es":"/nuevo"}, name="new", methods={"GET","POST"})
     */
    public function new(Request $request, CarManager $manager): Response
    {
        $page = $request->get('onPage');
        $car = $manager->new();
        $form = $this->createForm($manager->getFormClass(), $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('car_service_cars_index', [ 'page' => $page, ]);
        }

        return $this->render('@Cars/car/new.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
            'page' => $page,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(CarInterface $car): Response
    {
        return $this->render('@Cars/car/show.html.twig', [
            'car' => $car,
        ]);
    }

    /**
     * @Route({"en":"/{id}/edit","es":"/{id}/modificar"}, name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CarInterface $car, CarManager $manager): Response
    {
        $page = $request->get('onPage');
        $form = $this->createForm($manager->getFormClass(), $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('car_service_cars_index', [ 'page' => $page, ]);
        }

        return $this->render('@Cars/car/edit.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
            'page' => $page,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, CarInterface $car): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($car);
            $entityManager->flush();
        }

        return $this->redirectToRoute('car_service_cars_index', [ 'page' => $request->get('onPage') ]);
    }
}
