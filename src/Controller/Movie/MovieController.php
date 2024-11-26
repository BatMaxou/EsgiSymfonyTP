<?php

namespace App\Controller\Movie;

use App\Entity\Movie;
use App\Repository\PlaylistRepository;
use App\Repository\PlaylistSubscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    #[Route('/movies', name: 'movies')]
    public function movies(
        PlaylistRepository $playlistRepository,
        PlaylistSubscriptionRepository $playlistSubscriptionRepository,
    ) {
        $myPlaylists = $playlistRepository->findAll();
        $myPlaylistSubscriptions = $playlistSubscriptionRepository->findAll();

        return $this->render('movie/lists.html.twig', [
            'myPlaylists' => $myPlaylists,
            'myPlaylistSubscriptions' => $myPlaylistSubscriptions,
        ]);
    }

    #[Route('/movies/{id}/detail', name: 'movie')]
    public function movie(Movie $movie)
    {
        return $this->render('movie/detail.html.twig', [
            'movie' => $movie,
        ]);
    }
}
