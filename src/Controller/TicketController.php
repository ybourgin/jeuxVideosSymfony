<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Enum\TicketEnum;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TicketController extends AbstractController
{
    private EntityManagerInterface $em;
    private TicketRepository $ticketRepository;

    /**
     * TicketController constructor.
     * @param EntityManagerInterface $em
     * @param TicketRepository $ticketRepository
     */
    public function __construct(EntityManagerInterface $em, TicketRepository $ticketRepository)
    {
        $this->em = $em;
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * @Route("admin/ticket", name="ticket")
     */
    public function index(): Response
    {
        $ticketList = $this->ticketRepository->findAll();
        return $this->render('ticket/index.html.twig', [
            'controller_name' => 'TicketController',
            'ticketList' => $ticketList
        ]);
    }

    /**
     * @Route("/ticket/add_ticket", name="addTicket")
     */
    public function addTicket(Request $request): Response
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('app_login');
        } else {
            $ticketEntity = new Ticket();
            $form = $this->createForm(TicketType::class, $ticketEntity);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $ticketEntity->setCreateAt(new \DateTime());
                $ticketEntity->setUser($this->getUser());
                $ticketEntity->setStatus(TicketEnum::TICKET_UNREAD);
                $this->em->persist($ticketEntity);
                $this->em->flush();
                return $this->redirectToRoute('home');
            }
        }

        return $this->render('ticket/addTicket.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/ticket/readTicket/{id}", name="read_ticket")
     * @param Request $request
     * @param $id
     * @return Response
     */

    public function readTicket(Request $request, $id): Response
    {
        $ticketEntity = $this->ticketRepository->find($id);
        $user = $ticketEntity->getUser();
        if($ticketEntity->getStatus()==TicketEnum::TICKET_UNREAD)
        {
            $ticketEntity->setStatus(TicketEnum::TICKET_READ);
            $this->em->persist($ticketEntity);
            $this->em->flush();
        }
        return $this->render('ticket/readTicket.html.twig', [
            'ticketEntity' => $ticketEntity,
            'user' => $user
        ]);
    }

    /**
     * @Route("admin/ticket/treatedTicket/{id}", name="treated_ticket")
     * @param Request $request
     * @param $id
     * @return Response
     */

    public function treadTicket(Request $request, $id): Response
    {
        $ticketEntity = $this->ticketRepository->find($id);
        $currentUser = $this->getUser();
        $ticketEntity->setTreatedBy($currentUser);
        $ticketEntity->setStatus(TicketEnum::TICKET_TREATED);
        $this->em->persist($ticketEntity);
        $this->em->flush();
        return $this->redirectToRoute('ticket');
    }
}
