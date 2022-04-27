<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route({"en":"/","es":"/"}, name="car_service_main_")
 */
class MainController extends AbstractController
{
    /**
     * @Route({"en":"/delete-error/", "es":"error-al-borrar"}, name="delete_error", methods={"GET"})
     */
    public function deleteError(): Response
    {
        $response = $this->render('/main/delete_error.html.twig');

        return($response);
    }

    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function home(): Response
    {
        $response = $this->render('/main/home.html.twig');

        return($response);
    }    
}
