<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Filter\BudgetFilterType;
use App\Form\BudgetType;
use App\Repository\BudgetRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdater;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route({"en":"/budgets","es":"/presupuestos"}, name="car_service_budgets_")
 */
class BudgetController extends AbstractController
{
    /**
     * @Route({"en":"/index","es":"/indice"}, name="index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, BudgetRepository $budgetRepository, FilterBuilderUpdater $filterUpdater): Response
    {
        $limit = 10;

        $filter = $this->createForm(BudgetFilterType::class);
        $qb = $budgetRepository->index();

        $paginatorOptions =
        [
            // 'defaultSortFieldName' => 'budget.brand',
            // 'defaultSortDirection' => 'asc'
        ];

        if ($request->query->has($filter->getName())) 
        {
            // manually bind values from the request
            $filter->submit($request->query->get($filter->getName()));

            // initialize a query builder
            // $filterBuilder = $budgetRepository
            //     ->createQueryBuilder('budget')
            // ;

            // $filterBuilder = $budgetRepository->index();

            // build the query from the given form object
            $filterUpdater->addFilterConditions($filter, $qb);

            // now look at the DQL =)
            // var_dump($filterBuilder->getDql());

            // $qb = $filterBuilder;
        }
        // else
        // {
        //     $qb = $budgetRepository->index();
        // }

        $pagination = $paginator->paginate(
            $qb,                                    /* qb, not the result* */
            $request->query->getInt('page', 1)      /* page number */,
            $limit                                  /*l imit per page */,
            $paginatorOptions
       );        

        return $this->render('/budget/index.html.twig', [
            'pagination' => $pagination,
            'formFilter' => $filter->createView(),
        ]);
    }

    /**
     * @Route({"en":"/new","es":"/nuevo"}, name="new", methods={"GET","POST"})
     */
    public function new(Request $request, BudgetRepository $repositoy): Response
    {
        $budget = new Budget();
        $form = $this->createForm(BudgetType::class, $budget);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $repositoy->save($budget);
            $response = $this->redirectToRoute('budget_service_budgets_index');
        }
        else
        {
            $response = $this->render('/budget/new.html.twig', 
            [
                'budget' => $budget,
                'form' => $form->createView(),
            ]);
        }

        return($response);
    }

    /**
     * @Route({"en":"/{id}/edit","es":"/{id}/modifibudget"}, name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BudgetRepository $repository, Budget $budget): Response
    {
        $form = $this->createForm(BudgetType::class, $budget);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $repository->save($budget);

            $response = $this->redirectToRoute('budget_service_budgets_index');
        }
        else
        {
            $response =  $this->render('/budget/edit.html.twig', [
                'budget' => $budget,
                'form' => $form->createView(),
            ]);
        }

        return($response);
    }

    /**
     * @Route({"en":"/{id}/delete","es":"/{id}/borrar"}, name="delete", methods={"POST"})
     */
    public function delete(Request $request, BudgetRepository $repository, Budget $budget): Response
    {
        if ($this->isCsrfTokenValid('delete'.$budget->getId(), $request->request->get('_token'))) 
        {
            $repository->remove($budget);
        }

        $response = $this->redirectToRoute('budget_service_budgets_index');

        return($response);
    }
}
