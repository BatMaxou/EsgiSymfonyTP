<?php

namespace App\Controller\User;

use App\Repository\SubscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/subscriptions', name: 'subscriptions')]
    public function subscriptions(SubscriptionRepository $subscriptionRepository): Response
    {
        $subscriptions = $subscriptionRepository->findAll();

        return $this->render('user/subscriptions.html.twig', [
            'subscriptions' => $subscriptions,
        ]);
    }
}
