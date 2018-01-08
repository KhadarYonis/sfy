<?php
/**
 * Created by PhpStorm.
 * User: wabap2-13
 * Date: 05/01/18
 * Time: 14:30
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    /**
     * @Route("/contact/form", name="contact.form")
     */

    public function formAction(Request $request):Response
    {
        // On créer un contact
        $contact =  new Contact();

        // on récupère le formulaire
        $form = $this->createForm(ContactType::class, $contact);

        // récuperation des données dans la requète
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            // on enregistre le contact dans bdd
            $em = $this->getDoctrine()->getManager();

            $em->persist($contact);

            $em->flush();

            return new Response('Contact ajouté');
        }

        // on generer le html du formulaire crée
        $formView = $form->createView();

        // on rend la vue
        return $this->render('form/form.html.twig', [
            'form' => $formView
        ]);
    }
}