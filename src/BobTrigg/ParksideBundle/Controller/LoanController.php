<?php

namespace BobTrigg\ParksideBundle\Controller;

use BobTrigg\ParksideBundle\Entity\Loan;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Loan controller.
 *
 * @Route("loan")
 */
class LoanController extends Controller
{
    /**
     * Lists all loan entities.
     *
     * @Route("/", name="loan_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $loans = $em->getRepository('BobTriggParksideBundle:Loan')->findAll();

        return $this->render('loan/index.html.twig', array(
            'loans' => $loans,
        ));
    }

    /**
     * Creates a new loan entity.
     *
     * @Route("/new", name="loan_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $loan = new Loan();
        $form = $this->createForm('BobTrigg\ParksideBundle\Form\LoanType', $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($loan);
            $em->flush($loan);

            return $this->redirectToRoute('loan_show', array('id' => $loan->getId()));
        }

        return $this->render('loan/new.html.twig', array(
            'loan' => $loan,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a loan entity.
     *
     * @Route("/{id}", name="loan_show")
     * @Method("GET")
     */
    public function showAction(Loan $loan)
    {
        $deleteForm = $this->createDeleteForm($loan);

        return $this->render('loan/show.html.twig', array(
            'loan' => $loan,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing loan entity.
     *
     * @Route("/{id}/edit", name="loan_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Loan $loan)
    {
        $deleteForm = $this->createDeleteForm($loan);
        $editForm = $this->createForm('BobTrigg\ParksideBundle\Form\LoanType', $loan);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('loan_edit', array('id' => $loan->getId()));
        }

        return $this->render('loan/edit.html.twig', array(
            'loan' => $loan,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a loan entity.
     *
     * @Route("/{id}", name="loan_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Loan $loan)
    {
        $form = $this->createDeleteForm($loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($loan);
            $em->flush($loan);
        }

        return $this->redirectToRoute('loan_index');
    }

    /**
     * Creates a form to delete a loan entity.
     *
     * @param Loan $loan The loan entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Loan $loan)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('loan_delete', array('id' => $loan->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
