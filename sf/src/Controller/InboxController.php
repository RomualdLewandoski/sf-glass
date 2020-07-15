<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ReplyContactType;
use App\Repository\ContactRepository;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\This;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InboxController extends AbstractController
{
    /**
     * @Route("admin/inbox", name="inbox")
     */
    public function index(Request $request, ContactRepository $contactRepo, PaginatorInterface $paginator)
    {

        $pagination = $paginator->paginate(
            $contactRepo->getMessages(),
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('admin/pages/inbox/inbox.html.twig', [
            'title' => "boite de réception",
            'contacts' => $pagination,
            'unread' => count($contactRepo->getUnread())
        ]);
    }

    /**
     * @Route("admin/inbox/sent", name="inbox_sent")
     */
    public function getSent(ContactRepository $contactRepo, PaginatorInterface $paginator, Request $request)
    {
        $pagination = $paginator->paginate(
            $contactRepo->getReply(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('admin/pages/inbox/inbox.html.twig', [
            'title' => "Mail répondus",
            'contacts' => $pagination,
            'unread' => count($contactRepo->getUnread())
        ]);
    }

    /**
     * @Route("admin/inbox/trash", name="inbox_trash")
     */
    public function getTrash(ContactRepository $contactRepo, PaginatorInterface $paginator, Request $request)
    {
        $pagination = $paginator->paginate(
            $contactRepo->getTrash(),
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('admin/pages/inbox/inbox.html.twig', [
            'title' => "Corbeille",
            'contacts' => $pagination,
            'unread' => count($contactRepo->getUnread())
        ]);
    }

    /**
     * @Route("admin/inbox/toTrash/{id}", name="inbox_delete")
     */
    public function toTrash(int $id, ContactRepository $contactRepo)
    {
        $contact = $contactRepo->find($id);
        if ($contact == null) {
            return $this->redirectToRoute("inbox");
        } else {
            $contact->setIsTrash(!$contact->getIsTrash());
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("inbox");
        }
    }

    /**
     * @Route("admin/inbox/delete/{id}", name="inbox_remove")
     */
    public function removeContact(int $id, ContactRepository $contactRepo)
    {
        $contact = $contactRepo->find($id);
        if ($contact == null || !$contact->getIsTrash()) {
            return $this->redirectToRoute("inbox_trash");
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contact);
            $em->flush();
            return $this->redirectToRoute("inbox_trash");

        }
    }

    /**
     * @Route("admin/inbox/restore/all", name="inbox_restore_all")
     */
    public function restoreAll(ContactRepository $contactRepo)
    {
        $contacts = $contactRepo->getTrash();
        foreach ($contacts as $contact):
            $contact->setIsTrash(false);
        endforeach;
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute("inbox");
    }

    /**
     * @Route("admin/inbox/deleteAll/", name="inbox_delete_all")
     */
    public function removeAll(ContactRepository $contactRepo)
    {
        $contacts = $contactRepo->getTrash();
        $em = $this->getDoctrine()->getManager();
        foreach ($contacts as $contact):
            $em->remove($contact);
        endforeach;
        $em->flush();
        return $this->redirectToRoute("inbox");
    }

    /**
     * @Route("admin/inbox/star/{id}", name="inbox_star")
     */
    public function star(Request $request, int $id, ContactRepository $contactRepo)
    {
        $contact = $contactRepo->find($id);
        if (!$contact == null) {
            $contact->getIsStar() ? $contact->setIsStar(false) : $contact->setIsStar(true);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->redirectToRoute('inbox');
    }

    /**
     * @Route("admin/inbox/read/{id}", name="inbox_read")
     */
    public function read(Request $request, int $id, ContactRepository $contactRepo)
    {

        $contact = $contactRepo->find($id);
        if ($contact == null) {
            return $this->redirectToRoute("inbox");
        } else {
            if ($contact->getIsRead() == false) {
                $contact->setIsRead(true);
                $this->getDoctrine()->getManager()->flush();
            }

            return $this->render('admin/pages/inbox/read.html.twig', [
                'contact' => $contact,
                'unread' => count($contactRepo->getUnread())

            ]);
        }
    }

    /**
     * @Route("admin/inbox/getUnread", name="inbox_api_unread")
     */
    public function getUnread(ContactRepository $contactRepository)
    {
        $obj = new \stdClass();
        $obj->unread = count($contactRepository->getUnread());
        return new JsonResponse($obj);
    }

    /**
     * @Route("admin/inbox/reply/{id}", name="inbox_reply")
     */
    public function reply(Request $request, int $id, ContactRepository $contactRepo)
    {

        $contact = $contactRepo->find($id);
        if ($contact == null) {
            return $this->redirectToRoute("inbox");
        } else {
            $form = $this->createForm(ReplyContactType::class, $contact);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $contact->setReplyAt(new \DateTime('now'));
                $em->flush();
                $transport = (new \Swift_SmtpTransport('moonly.fr', 25))
                    ->setUsername("admin@moonly.fr")
                    ->setPassword("Afpagroupe6");
                $message = (new \Swift_Message("RE: " . $contact->getSubject()))
                    ->setFrom('admin@moonly.fr')
                    ->setTo($contact->getEmail())
                    ->setBody("<blockquote>
                                        " . $contact->getComment() . "
                                      </blockquote><br>" . $contact->getReply(), 'text/html');
                $mailer = new Swift_Mailer($transport);

                $mailer->send($message);
                return $this->redirectToRoute("inbox_read", ['id' => $id]);
            }
            return $this->render('admin/pages/inbox/reply.html.twig', [
                'contact' => $contact,
                'replyForm' => $form->createView(),
                'unread' => count($contactRepo->getUnread())
            ]);
        }
    }
}
