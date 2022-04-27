<?php

namespace App\Controller;

use App\Entity\Car;
use App\Filter\CarFilterType;
use App\Form\CarType;
use App\Repository\CarRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdater;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route({"en":"/cars","es":"/marcas"}, name="car_service_cars_")
 */
class CarController extends AbstractController
{
    /**
     * @Route({"en":"/index","es":"/indice"}, name="index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, CarRepository $carRepository, FilterBuilderUpdater $filterUpdater): Response
    {
        $limit = 10;

        $filter = $this->createForm(CarFilterType::class);

        $paginatorOptions =
        [
            // 'defaultSortFieldName' => 'car.brand',
            // 'defaultSortDirection' => 'asc'
        ];

        if ($request->query->has($filter->getName())) 
        {
            // manually bind values from the request
            $filter->submit($request->query->get($filter->getName()));

            // initialize a query builder
            $filterBuilder = $carRepository
                ->createQueryBuilder('e')
            ;

            // build the query from the given form object
            $filterUpdater->addFilterConditions($filter, $filterBuilder);

            // now look at the DQL =)
            // var_dump($filterBuilder->getDql());
        }

        $pagination = $paginator->paginate(
            // $carRepository->index(),
            $filterBuilder,
            $request->query->getInt('page', 1)      /*page number*/,
            $limit                                  /*limit per page*/,
            $paginatorOptions
       );        

        return $this->render('/car/index.html.twig', [
            'pagination' => $pagination,
            'formFilter' => $filter->createView(),
        ]);
    }

    /**
     * @Route({"en":"/new","es":"/nuevo"}, name="new", methods={"GET","POST"})
     */
    public function new(Request $request, CarRepository $repositoy): Response
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $repositoy->save($car);
            $response = $this->redirectToRoute('car_service_cars_index');
        }
        else
        {
            $response = $this->render('/car/new.html.twig', 
            [
                'car' => $car,
                'form' => $form->createView(),
            ]);
        }

        return($response);
    }

    /**
     * @Route({"en":"/{id}/edit","es":"/{id}/modificar"}, name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CarRepository $repository, Car $car): Response
    {
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $repository->save($car);

            $response = $this->redirectToRoute('car_service_cars_index');
        }
        else
        {
            $response =  $this->render('/car/edit.html.twig', [
                'car' => $car,
                'form' => $form->createView(),
            ]);
        }

        return($response);
    }

    /**
     * @Route({"en":"/{id}/delete","es":"/{id}/borrar"}, name="delete", methods={"POST"})
     */
    public function delete(Request $request, CarRepository $repository, Car $car): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) 
        {
            $repository->remove($car);
        }

        $response = $this->redirectToRoute('car_service_cars_index');

        return($response);
    }
}
