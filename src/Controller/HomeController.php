<?php

namespace App\Controller;

use App\Entity\PlaylistSubscription;
use App\Repository\MediaRepository;
use App\Repository\PlaylistRepository;
use App\Repository\PlaylistSubscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(MediaRepository $mediaRepository,): Response
    {
        $popularMedias = $mediaRepository->findPopular(9);

        return $this->render('index.html.twig', [
            'popularMedias' => $popularMedias
        ]);
    }
}
