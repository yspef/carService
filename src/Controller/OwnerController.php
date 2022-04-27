<?php

namespace App\Controller;

use App\Entity\Owner;
use App\Form\OwnerType;
use App\Repository\OwnerRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route({"en":"/owners","es":"/owneres"}, name="car_service_owners_")
 */
class OwnerController extends AbstractController
{
    /**
     * @Route({"en":"/index","es":"/indice"}, name="index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, OwnerRepository $ownerRepository): Response
    {
        $limit = 10;

        $paginatorOptions = [];

        $pagination = $paginator->paginate(
            $ownerRepository->index(),
            $request->query->getInt('page', 1)      /*page number*/,
            $limit                                  /*limit per page*/,
            $paginatorOptions
       );        

        return $this->render('/owner/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route({"en":"/new","es":"/nuevo"}, name="new", methods={"GET","POST"})
     */
    public function new(Request $request, OwnerRepository $repositoy): Response
    {
        $owner = new Owner();
        $form = $this->createForm(OwnerType::class, $owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $repositoy->save($owner);
            $response = $this->redirectToRoute('car_service_owners_index');
        }
        else
        {
            $response = $this->render('/owner/new.html.twig', 
            [
                'owner' => $owner,
                'form' => $form->createView(),
            ]);
        }

        return($response);
    }

    /**
     * @Route({"en":"/{id}/edit","es":"/{id}/modificar"}, name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OwnerRepository $repository, Owner $owner): Response
    {
        $form = $this->createForm(OwnerType::class, $owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $repository->save($owner);

            $response = $this->redirectToRoute('car_service_owners_index');
        }
        else
        {
            $response =  $this->render('/owner/edit.html.twig', [
                'owner' => $owner,
                'form' => $form->createView(),
            ]);
        }

        return($response);
    }

    /**
     * @Route({"en":"/{id}/delete","es":"/{id}/borrar"}, name="delete", methods={"POST"})
     */
    public function delete(Request $request, OwnerRepository $repository, Owner $owner): Response
    {
        try
        {
            if ($this->isCsrfTokenValid('delete'.$owner->getId(), $request->request->get('_token'))) 
            {
                $repository->remove($owner);
            }

            $response = $this->redirectToRoute('car_service_owners_index');
        }
        catch(ForeignKeyConstraintViolationException $e)
        {
            $response = $this->redirectToRoute('car_service_main_delete_error');
        }

        return($response);
    }
}
