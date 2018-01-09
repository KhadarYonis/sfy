<?php
/**
 * Created by PhpStorm.
 * User: wabap2-13
 * Date: 04/01/18
 * Time: 12:21
 */

namespace AppBundle\Twig;

/*
    * création de fonctions et filters twig :
    * - classe extends \Twig_Extension
    *
 */

use AppBundle\Entity\Formation;
use Doctrine\Common\Persistence\ManagerRegistry;

class AppExtension extends \Twig_Extension
{

    /*
     * injection de services dans une classe autre qu'un contrôleur
     *  créer une propriéte par service
     *  injecter les services par le constructeur
     */

    private $doctrine;
    private $twig;

    public function __construct(ManagerRegistry $doctrine, \Twig_Environment $twig)
    {
        $this->doctrine = $doctrine;
        $this->twig = $twig;


    }


    /*
    * CREATION FONCTION
    */


    /*
     * création d'une fonction
     * - renvoie un array de nouvelle fonctions,
     *      - 1er param : non de la fonction dans twig
     *      - 2eme param : collable PHP
     *          - objet possèdant la méthode appelée : $this => class
     *          - non de la fonction php appelée
     *
     * */

    public function getFunctions():array
    {
        return [
            new \Twig_SimpleFunction('my_test', [$this, 'mytest']),
            new \Twig_SimpleFunction('date_diff', [$this, 'dateDiff']),
            new \Twig_SimpleFunction('render_menu', [$this, 'create_menu'])
        ];
    }

    public function myTest()
    {
        return 'my test';
    }

    public function dateDiff(\DateTime $postdate)
    {
        $now = new \DateTime();

        $diff = $now->diff($postdate);

        return [
            "year" => $diff->y,
            "month" => $diff->m,
            "day" => $diff->d,
            "hour" => $diff->h,
            "min" => $diff->i
        ];
    }

    public function create_menu()
    {
        //requête avec le service doctrine

        $rc = $this->doctrine->getRepository(Formation::class);
        $formations = $rc->findAll();

        // envoie des resultats à une vue partielle

        return $this->twig->render('inc/menu.html.twig', [
            'formations' => $formations
        ]);

    }


   /*
    * CREATION FILTER
    */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('slugify', [$this, 'slugify'])
        ];
    }

    /*
     *
     * */
    public function slugify($value)
    {
        $string = transliterator_transliterate("Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();", $value);
        $string = preg_replace('/[-\s]+/', '-', $string);
        return trim($string, '-');
    }
}