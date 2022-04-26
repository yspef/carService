<?php

namespace App\Controller;

use App\Entity\Model;
use App\Form\ModelType;
use App\Repository\BrandRepository;
use App\Repository\ModelRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route({"en":"/models","es":"/marcas"}, name="car_service_models_")
 */
class ModelController extends AbstractController
{
    /**
     * @Route("/ajax/by-brand", name="by_brand", methods={"POST"}, condition="request.isXmlHttpRequest()")
     */
    public function byBrand(Request $request, BrandRepository $brandRepository, ModelRepository $modelRepository): JsonResponse
    {
        $models = [];

        if(null != ($brandId = $request->get('id')))
        {
            $brand = $brandRepository->find($brandId);
            $rows = $modelRepository->findBy(['brand' => $brand], ['description' => 'asc']);

            foreach($rows as $row)
            {
                $option['id'] = $row->getId();
                $option['description'] = $row->getDescription();

                $models[] = $option;
            }
        }
        
        $response = new JsonResponse([ 
                                        'models' => $models,
                                     ]);

        return($response);
    }

    /**
     * @Route({"en":"/index","es":"/indice"}, name="index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, ModelRepository $modelRepository): Response
    {
        $limit = 10;

        $paginatorOptions =
        [
            'defaultSortFieldName' => 'model.description',
            'defaultSortDirection' => 'asc'
        ];

        $pagination = $paginator->paginate(
            $modelRepository->index(),
            $request->query->getInt('page', 1)      /*page number*/,
            $limit                                  /*limit per page*/,
            $paginatorOptions
       );        

        return $this->render('/model/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route({"en":"/new","es":"/nuevo"}, name="new", methods={"GET","POST"})
     */
    public function new(Request $request, ModelRepository $repositoy): Response
    {
        $model = new Model();
        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $repositoy->save($model);
            $response = $this->redirectToRoute('car_service_models_index');
        }
        else
        {
            $response = $this->render('/model/new.html.twig', 
            [
                'model' => $model,
                'form' => $form->createView(),
            ]);
        }

        return($response);
    }

    /**
     * @Route({"en":"/{id}/edit","es":"/{id}/modificar"}, name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ModelRepository $repository, Model $model): Response
    {
        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $repository->save($model);

            $response = $this->redirectToRoute('car_service_models_index');
        }
        else
        {
            $response =  $this->render('/model/edit.html.twig', [
                'model' => $model,
                'form' => $form->createView(),
            ]);
        }

        return($response);
    }

    /**
     * @Route({"en":"/{id}/delete","es":"/{id}/borrar"}, name="delete", methods={"POST"})
     */
    public function delete(Request $request, ModelRepository $repository, Model $model): Response
    {
        if ($this->isCsrfTokenValid('delete'.$model->getId(), $request->request->get('_token'))) 
        {
            $repository->remove($model);
        }

        $response = $this->redirectToRoute('car_service_models_index');

        return($response);
    }
}
