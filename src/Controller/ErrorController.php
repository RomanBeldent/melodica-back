<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    /**
     * Méthode gérant l'affichage de la page 404
     *
     * @return void
     */
    public function show()
    {
        return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
    }
}
