<?php

namespace App\Controller;

use App\Entity\PostCategory;
use App\Form\PostCategoryType;
use App\Repository\PostCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostCategoryController extends AbstractController
{
    private EntityManagerInterface $em;
    private PostCategoryRepository $postCategoryRepository;

    /**
     * PostCategoryController constructor.
     * @param EntityManagerInterface $em
     * @param PostCategoryRepository $postCategoryRepository
     */
    public function __construct(EntityManagerInterface $em, PostCategoryRepository $postCategoryRepository)
    {
        $this->em = $em;
        $this->postCategoryRepository = $postCategoryRepository;
    }

    /**
     * @Route("admin/post/category", name="post_category")
     */
    public function index(): Response
    {
        $categoryList = $this->postCategoryRepository->findAll();
        return $this->render('post_category/index.html.twig', [
            'controller_name' => 'PostCategoryController',
            'categoryList'=>$categoryList,
        ]);
    }
    /**
     * @Route("admin/post/addCategory", name="post_addCategory")
     */
    public function addCategory(Request $request): Response
    {
        $categoryEntity = new PostCategory();
        $form = $this->createForm(PostCategoryType::class, $categoryEntity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $this->em->persist($categoryEntity);
            $this->em->flush();
            return $this->redirectToRoute('post_category');
        }

        return $this->render('post_category/addCategory.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/post/editCategory/{id}", name="post_editCategory")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editCategory(Request $request, $id): Response
    {
        $categoryEntity = $this->postCategoryRepository->find($id);
        $form = $this->createForm(PostCategoryType::class, $categoryEntity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($categoryEntity);
            $this->em->flush();
            return $this->redirectToRoute('post_category');
        }

        return $this->render('post_category/editCategory.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("admin/post/removeCategory/{id}", name="post_removeCategory")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function removeCategory(Request $request, $id): Response
    {
        $categoryEntity = $this->postCategoryRepository->find($id);
        $this->em->remove($categoryEntity);
        $this->em->flush();

        return $this->redirectToRoute('post_category');
    }

}
