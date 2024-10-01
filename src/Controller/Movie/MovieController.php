<?php

namespace App\Controller\Movie;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    #[Route('/movies/discover', name: 'discover')]
    public function discover()
    {
        return $this->render('movie/discover.html.twig');
    }

    #[Route('/movies', name: 'movies')]
    public function movies()
    {
        return $this->render('movie/lists.html.twig');
    }

    #[Route('/movies/detail', name: 'movie')]
    public function movie()
    {
        return $this->render('movie/detail.html.twig');
    }
}
