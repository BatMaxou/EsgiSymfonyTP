<?php

namespace App\Controller\Movie;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class SerieController extends AbstractController
{
    #[Route('/movies/series/detail', name: 'serie')]
    public function serie()
    {
        return $this->render('movie/detail_serie.html.twig');
    }
}
