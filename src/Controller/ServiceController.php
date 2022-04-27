<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route({"en":"/services","es":"/servicios"}, name="car_service_services_")
 */
class ServiceController extends AbstractController
{
    /**
     * @Route({"en":"/index","es":"/indice"}, name="index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, ServiceRepository $serviceRepository): Response
    {
        $limit = 10;

        $paginatorOptions =
        [
            'defaultSortFieldName' => 'service.description',
            'defaultSortDirection' => 'asc'
        ];

        $pagination = $paginator->paginate(
            $serviceRepository->index(),
            $request->query->getInt('page', 1)      /*page number*/,
            $limit                                  /*limit per page*/,
            $paginatorOptions
       );        

        return $this->render('/service/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route({"en":"/new","es":"/nuevo"}, name="new", methods={"GET","POST"})
     */
    public function new(Request $request, ServiceRepository $repositoy): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $repositoy->save($service);
            $response = $this->redirectToRoute('car_service_services_index');
        }
        else
        {
            $response = $this->render('/service/new.html.twig', 
            [
                'service' => $service,
                'form' => $form->createView(),
            ]);
        }

        return($response);
    }

    /**
     * @Route({"en":"/{id}/edit","es":"/{id}/modificar"}, name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ServiceRepository $repository, Service $service): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $repository->save($service);

            $response = $this->redirectToRoute('car_service_services_index');
        }
        else
        {
            $response =  $this->render('/service/edit.html.twig', [
                'service' => $service,
                'form' => $form->createView(),
            ]);
        }

        return($response);
    }

    /**
     * @Route({"en":"/{id}/delete","es":"/{id}/borrar"}, name="delete", methods={"POST"})
     */
    public function delete(Request $request, ServiceRepository $repository, Service $service): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) 
        {
            $repository->remove($service);
        }

        $response = $this->redirectToRoute('car_service_services_index');

        return($response);
    }
}
