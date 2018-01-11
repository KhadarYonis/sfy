<?php
/**
 * Created by PhpStorm.
 * User: wabap2-13
 * Date: 11/01/18
 * Time: 14:08
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class TranslationController
 * @package AppBundle\Controller
 *
 * @Route("/{_locale}")
 */

class TranslationController extends Controller
{
    /**
     * @Route("/translation", name="translation.index")
     */

    public function indexAction(Request $request, TranslatorInterface $translator):Response
    {

        /*
         * accéder à la locale : à partir de la requête
         * accéder au service de traduction : TranslatorInterface
         */

       // dump($request->getLocale(), $translator->trans('content.remplacement', ['%name%' => 'Charo']));



        return $this->render('translation/index.html.twig', [
            'now' => new \DateTime()
        ]);
    }
}