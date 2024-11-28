<?php

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/register', name: 'register')]
    public function register()
    {
        return $this->render('auth/register.html.twig');
    }

    #[Route('/forgot-password', name: 'forgot')]
    public function forgot()
    {
        return $this->render('auth/forgot.html.twig');
    }

    #[Route('/reset', name: 'reset')]
    public function reset()
    {
        return $this->render('auth/reset.html.twig');
    }

    #[Route('/confirm', name: 'confirm')]
    public function confirm()
    {
        return $this->render('auth/confirm.html.twig');
    }
}
