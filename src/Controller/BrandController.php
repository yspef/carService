<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Form\BrandType;
use App\Repository\BrandRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route({"en":"/brands","es":"/marcas"}, name="car_service_brands_")
 */
class BrandController extends AbstractController
{
    /**
     * @Route({"en":"/index","es":"/indice"}, name="index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, BrandRepository $brandRepository): Response
    {
        $limit = 10;

        $paginatorOptions = [];

        $pagination = $paginator->paginate(
            $brandRepository->index(),
            $request->query->getInt('page', 1)      /*page number*/,
            $limit                                  /*limit per page*/,
            $paginatorOptions
       );        

        return $this->render('/brand/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route({"en":"/new","es":"/nuevo"}, name="new", methods={"GET","POST"})
     */
    public function new(Request $request, BrandRepository $repositoy): Response
    {
        $brand = new Brand();
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $repositoy->save($brand);
            $response = $this->redirectToRoute('car_service_brands_index');
        }
        else
        {
            $response = $this->render('/brand/new.html.twig', 
            [
                'brand' => $brand,
                'form' => $form->createView(),
            ]);
        }

        return($response);
    }

    /**
     * @Route({"en":"/{id}/edit","es":"/{id}/modificar"}, name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BrandRepository $repository, Brand $brand): Response
    {
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $repository->save($brand);

            $response = $this->redirectToRoute('car_service_brands_index');
        }
        else
        {
            $response =  $this->render('/brand/edit.html.twig', [
                'brand' => $brand,
                'form' => $form->createView(),
            ]);
        }

        return($response);
    }

    /**
     * @Route({"en":"/{id}/delete","es":"/{id}/borrar"}, name="delete", methods={"POST"})
     */
    public function delete(Request $request, BrandRepository $repository, Brand $brand): Response
    {
        try
        {
            if ($this->isCsrfTokenValid('delete'.$brand->getId(), $request->request->get('_token'))) 
            {
                $repository->remove($brand);
            }

            $response = $this->redirectToRoute('car_service_brands_index');
        }
        catch(ForeignKeyConstraintViolationException $e)
        {
            $response = $this->redirectToRoute('car_service_main_delete_error');
        }

        return($response);
    }
}
