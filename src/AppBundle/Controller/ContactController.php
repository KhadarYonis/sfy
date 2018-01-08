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
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact.index")
     */

    public function indexAction(ManagerRegistry $doctrine):Response
    {
        /**
         * getRepository : cible la classe Repository d'une entité
         * méthodes de selection fournies par défauts
         *      findAll() : renvoie un array d'entité
         *      find($id) : renvoie une entité par son id
         *      findOneBy($conditions) : renvoie une entité en ciblant la valeur de colonnes
         *      findBy($conditions) : renvoie un array entité en ciblant la valeur de colonnes
         *
         */

        $rc = $doctrine->getRepository(Contact::class);

        $results = $rc->findAll();

        //dump($results);exit;

        return $this->render('contact/index.html.twig', [
            'results' => $results
        ]);
    }


    /**
     * @Route("/contact/form",
     *      name="contact.form",
     *     defaults={"id"= null}
     *     )
     * @Route("/contact/form/update/{id}",
     *     name="contact.form.update"
     *     )
     */

    public function formAction(Request $request, ManagerRegistry $doctrine, $id = null):Response
    {
        // On créer un contact



        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Contact::class);


        $contact = $id ? $rc->find($id) : new Contact();

        // on récupère le formulaire
        $form = $this->createForm(ContactType::class, $contact);

        // récuperation des données dans la requète
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            // on enregistre le contact dans bdd sans ManagerRegister

            //$data = $form->getData();

           // $em = $this->getDoctrine()->getManager();



            $em->persist($contact);

            $em->flush();

            //return new Response('message ok');

            /**
             * message flash :  message en session affiché une seule fois
             *      - clé  créée en session
             *      - valeur de la clé
             */

            $message =  $id ? 'Le contact a été bien modifié' : 'Le contact a été bien ajouté';

            $this->addFlash('notice', $message);

            return $this->redirectToRoute('contact.index');



        }

        // on generer le html du formulaire crée
        $formView = $form->createView();

        // on rend la vue
        return $this->render('contact/form.html.twig', [
            'form' => $formView
        ]);
    }



    /**
     * @Route("/contact/delete/{id}", name="contact.form.delete")
     */

    public function deleteAction(ManagerRegistry $doctrine, int $id):Response
    {
        // action de suppression : sélection de l'entité puis suppression
        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Contact::class);

        // sélection de l'entité

        $contact =  $rc->find($id);

        // dump($contact); exit;


        // suppression : méthode rempove en remplaçant de persist

        $em->remove($contact);

        $em->flush();

        $this->addFlash('notice', 'Le contact est bien supprimé');

        return $this->redirectToRoute('contact.index');
    }

}