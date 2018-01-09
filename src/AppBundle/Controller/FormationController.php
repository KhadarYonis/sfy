<?php
/**
 * Created by PhpStorm.
 * User: wabap2-13
 * Date: 09/01/18
 * Time: 12:12
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Formation;
use AppBundle\Entity\Module;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FormationController extends Controller
{
    /**
     * @Route("/trainings", name="formation.index")
     */
    public function indexAction(ManagerRegistry $doctrine):Response
    {

        /*$rc = $doctrine->getRepository(Formation::class);
        $formations = $rc->findAll();*/


        return $this->render('formation/index.html.twig', [
            //'formations' => $formations
        ]);
    }


    /**
     * @Route("/training/{id}",
     *      name="formation.formation"
     *     )
     */
    public function formationAction(ManagerRegistry $doctrine,int $id):Response
    {
        $rc = $doctrine->getRepository(Formation::class);

        //$formations = $rc->findAll();

        $formation = $rc->find($id);


        return $this->render('formation/formation.html.twig', [
            //'formations' => $formations,
            'formation' => $formation
        ]);
    }


    /**
     * @Route("/module/{id}",
     *      name="formation.module"
     *     )
     */
    public function moduleAction(ManagerRegistry $doctrine,int $id):Response
    {
        $rc = $doctrine->getRepository(Module::class);

        //$modules= $rc->findAll();

        $module= $rc->find($id);



        return $this->render('formation/module.html.twig', [
            //'modules' => $modules,
            'module' => $module,
        ]);
    }
}