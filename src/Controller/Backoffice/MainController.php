<?php

namespace App\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back")
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", name="back_index")
     */
    public function index(): Response
    {

        return $this->render('main/index.html.twig', [
        ]);
        
    }
}
