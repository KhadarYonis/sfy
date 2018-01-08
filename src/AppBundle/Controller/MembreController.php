<?php
/**
 * Created by PhpStorm.
 * User: wabap2-13
 * Date: 05/01/18
 * Time: 09:51
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MembreController extends Controller
{
    public $membres = array(
        array('firstname' => 'First name member1', 'lastname' => 'last name member1'),
        array('firstname' => 'First name member2', 'lastname' => 'last name member2'),
        array('firstname' => 'First name member3', 'lastname' => 'last name member3'),
        array('firstname' => 'First name member4', 'lastname' => 'last name member4'),
        array('firstname' => 'First name member5', 'lastname' => 'last name member5'),
        array('firstname' => 'First name member6', 'lastname' => 'last name member6')
    );

    /**
     * @Route("/membres", name="membre.membres")
     */

    public function membresAction():Response
    {


        return $this->render('membre/membres.html.twig', [
            'membres' => $this->membres
        ]);
    }


    /**
     * @Route("/membre/{id}", name="membre.membre")
     */

    public function membreAction($id):Response
    {

        return $this->render('membre/membre.html.twig', [
            'id' => $id, 'membre' => $this->membres[$id]
        ]);
    }




}