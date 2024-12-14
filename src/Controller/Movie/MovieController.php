<?php

namespace App\Controller\Movie;

use App\Entity\Movie;
use App\Repository\CommentRepository;
use App\Repository\PlaylistRepository;
use App\Repository\PlaylistSubscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    #[Route('/movies', name: 'movies')]
    public function movies(
        Request $request,
        PlaylistRepository $playlistRepository,
        PlaylistSubscriptionRepository $playlistSubscriptionRepository,
    ) {
        $myPlaylists = $playlistRepository->findAll();
        $myPlaylistSubscriptions = $playlistSubscriptionRepository->findAll();

        $selectedPlaylistId = $request->query->get('playlist', null);
        $selectedPlaylist = null;
        if (null !== $selectedPlaylistId) {
            $selectedPlaylist = $playlistRepository->find($selectedPlaylistId);
        }

        return $this->render('movie/lists.html.twig', [
            'myPlaylists' => $myPlaylists,
            'myPlaylistSubscriptions' => $myPlaylistSubscriptions,
            'selectedPlaylist' => $selectedPlaylist,
        ]);
    }

    #[Route('/movies/{id}/detail', name: 'movie')]
    public function movie(Movie $movie, CommentRepository $commentRepository)
    {
        $parentComments = $commentRepository->getParentCommentsFor($movie);

        return $this->render('movie/detail.html.twig', [
            'movie' => $movie,
            'parentComments' => $parentComments,
        ]);
    }
}
