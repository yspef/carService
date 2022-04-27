<?php

namespace App\Controller;

use App\Entity\Color;
use App\Form\ColorType;
use App\Repository\ColorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route({"en":"/colors","es":"/colores"}, name="car_service_colors_")
 */
class ColorController extends AbstractController
{
    /**
     * @Route({"en":"/index","es":"/indice"}, name="index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, ColorRepository $colorRepository): Response
    {
        $limit = 10;

        $paginatorOptions =
        [
            // 'defaultSortFieldName' => 'color.description',
            // 'defaultSortDirection' => 'asc'
        ];

        $pagination = $paginator->paginate(
            $colorRepository->index(),
            $request->query->getInt('page', 1)      /*page number*/,
            $limit                                  /*limit per page*/,
            $paginatorOptions
       );        

        return $this->render('/color/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route({"en":"/new","es":"/nuevo"}, name="new", methods={"GET","POST"})
     */
    public function new(Request $request, ColorRepository $repositoy): Response
    {
        $color = new Color();
        $form = $this->createForm(ColorType::class, $color);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $repositoy->save($color);
            $response = $this->redirectToRoute('car_service_colors_index');
        }
        else
        {
            $response = $this->render('/color/new.html.twig', 
            [
                'color' => $color,
                'form' => $form->createView(),
            ]);
        }

        return($response);
    }

    /**
     * @Route({"en":"/{id}/edit","es":"/{id}/modificar"}, name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ColorRepository $repository, Color $color): Response
    {
        $form = $this->createForm(ColorType::class, $color);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $repository->save($color);

            $response = $this->redirectToRoute('car_service_colors_index');
        }
        else
        {
            $response =  $this->render('/color/edit.html.twig', [
                'color' => $color,
                'form' => $form->createView(),
            ]);
        }

        return($response);
    }

    /**
     * @Route({"en":"/{id}/delete","es":"/{id}/borrar"}, name="delete", methods={"POST"})
     */
    public function delete(Request $request, ColorRepository $repository, Color $color): Response
    {
        if ($this->isCsrfTokenValid('delete'.$color->getId(), $request->request->get('_token'))) 
        {
            $repository->remove($color);
        }

        $response = $this->redirectToRoute('car_service_colors_index');

        return($response);
    }
}
