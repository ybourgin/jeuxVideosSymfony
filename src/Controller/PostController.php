<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    private EntityManagerInterface $em;
    private PostRepository $PostRepository;

    /**
     * PostController constructor.
     * @param EntityManagerInterface $em
     * @param PostRepository $PostRepository
     */
    public function __construct(EntityManagerInterface $em, PostRepository $PostRepository)
    {
        $this->em = $em;
        $this->PostRepository = $PostRepository;
    }

    /**
     * @Route("admin/post", name="post")
     */
    public function index(): Response
    {
        $postList = $this->PostRepository->findAll();
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'postList'=>$postList
        ]);
    }

    /**
     * @Route("admin/post/addPost", name="post_add")
     */
    public function add(Request $request): Response
    {
        $postEntity = new Post();
        $form = $this->createForm(PostType::class, $postEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postEntity->setCreatedAt(new \DateTime());
            $postEntity->setStatus(0);
            $postEntity->setNumberView(0);
            $postEntity->setUser($this->getUser());
            $this->em->persist($postEntity);
            $this->em->flush();
            return $this->redirectToRoute('post');
        }

        return $this->render('post/addPost.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("admin/post/editPost/{id}", name="post_edit")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editPost(Request $request, $id): Response
    {
        $postEntity = $this->PostRepository->find($id);
        $form = $this->createForm(PostType::class, $postEntity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($postEntity);
            $this->em->flush();
            return $this->redirectToRoute('post');
        }

        return $this->render('post/editPost.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("admin/post/removePost/{id}", name="post_remove")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function removePost(Request $request, $id): Response
    {
        $postEntity = $this->PostRepository->find($id);
        $this->em->remove($postEntity);
        $this->em->flush();

        return $this->redirectToRoute('post');
    }

    /**
     * @Route("/post/detailPost/{id}", name="post_detail")
     * @param $id
     * @return Response
     */
    public function detailPost($id): Response
    {
        $postEntity = $this->PostRepository->find($id);
        $cptWiew=$postEntity->getNumberView();
        $postEntity->setNumberView($cptWiew+1);
        $this->em->persist($postEntity);
        $this->em->flush();

        return $this->render('post/detailPost.html.twig', [
            'controller_name' => 'PostController',
            'postEntity'=>$postEntity
        ]);
    }
}
