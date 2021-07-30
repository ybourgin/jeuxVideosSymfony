<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;

class HomeController extends AbstractController
{
    private postRepository $PostRepository;

    /**
     * HomeController constructor.
     * @param PostRepository $PostRepository
     */
    public function __construct(PostRepository $PostRepository)
    {
        $this->PostRepository = $PostRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/admin", name="homeAdmin")
     */
    public function indexAdmin(): Response
    {
        return $this->render('home/indexAdmin.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function displayPost(): Response
    {
        $postList = $this->PostRepository->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'DisplayPost',
            'postList'=>$postList
        ]);
    }
}
