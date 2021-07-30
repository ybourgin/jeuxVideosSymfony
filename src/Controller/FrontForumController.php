<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Repository\ForumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/forum")
 */
class FrontForumController extends AbstractController
{
    /**
     * @Route("/", name="frontForum_index", methods={"GET"})
     */
    public function index(ForumRepository $forumRepository): Response
    {
        return $this->render('front_forum/index.html.twig', [
            'forums' => $forumRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="frontForum_show", methods={"GET"})
     */
    public function show(Forum $forum): Response
    {
        return $this->render('front_forum/show.html.twig', [
            'forum' => $forum,
        ]);
    }
}
