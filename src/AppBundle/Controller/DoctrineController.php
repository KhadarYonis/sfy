<?php
/**
 * Created by PhpStorm.
 * User: wabap2-13
 * Date: 10/01/18
 * Time: 11:42
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Contact;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DoctrineController extends Controller
{

    /**
     * @Route("/query", name="doctrine.index")
     *
     */

    public function indexAction(ManagerRegistry $doctrine)
    {

        // on recupérer l'entité (que on souhait affiché ) puis le méthode associé dans Repository
        $results = $doctrine->getRepository(Contact::class)->testDelete();

        dump($results); exit();
    }
}