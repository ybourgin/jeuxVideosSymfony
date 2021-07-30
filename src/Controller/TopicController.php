<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Form\TopicType;
use App\Repository\ForumRepository;
use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/topic")
 */

class TopicController extends AbstractController
{
    private ForumRepository $forumRepository;

    /**
     * TopicController constructor.
     * @param ForumRepository $forumRepository
     */
    public function __construct(ForumRepository $forumRepository)
    {
        $this->forumRepository = $forumRepository;
    }

    /**
     * @Route("/{id}", name="topic_index", methods={"GET"})
     */
    public function index(TopicRepository $topicRepository, string $id): Response
    {
        return $this->render('topic/index.html.twig', [
            'forums' => $this->forumRepository->find($id),
            'topics' => $topicRepository->findBy(['forum'=>$id]),
        ]);
    }
    /**
     * @Route("/new/{id}", name="topic_new", methods={"GET","POST"})
     */
    public function new(Request $request, int $id): Response
    {
        $topic = new Topic();
        $forum=$this->forumRepository->find($id);
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $topic->setCreatedAt(new \DateTime());
            $topic->setForum($forum);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($topic);
            $entityManager->flush();

            return $this->redirectToRoute('topic_index', ['id'=>$id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('topic/new.html.twig', [
            'topic' => $topic,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show/{id}", name="topic_show", methods={"GET"})
     */
    public function show(Topic $topic, int $id): Response
    {
        return $this->render('topic/show.html.twig', [
            'topic' => $topic,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="topic_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Topic $topic): Response
    {
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('topic_index', ['id'=>$topic->getForum()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('topic/edit.html.twig', [
            'topic' => $topic,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="topic_delete", methods={"POST"})
     */
    public function delete(Request $request, Topic $topic): Response
    {
        if ($this->isCsrfTokenValid('delete'.$topic->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($topic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('topic_index', [], Response::HTTP_SEE_OTHER);
    }
}
