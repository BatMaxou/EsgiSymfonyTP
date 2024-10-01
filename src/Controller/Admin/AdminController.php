<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function admin()
    {
        return $this->render('admin/admin.html.twig');
    }

    #[Route('/admin/movies/add', name: 'admin_movies_add')]
    public function addMovie()
    {
        return $this->render('admin/admin_add_films.html.twig');
    }

    #[Route('/admin/movies', name: 'admin_movies')]
    public function movies()
    {
        return $this->render('admin/admin_films.html.twig');
    }

    #[Route('/admin/users', name: 'admin_users')]
    public function users()
    {
        return $this->render('admin/admin_users.html.twig');
    }
}
