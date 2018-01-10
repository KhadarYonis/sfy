<?php
/**
 * Created by PhpStorm.
 * User: wabap2-13
 * Date: 10/01/18
 * Time: 10:13
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LanguageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /*
         * utilisation des entités
         * $nanager équivant à doctrine
         * chaque insertion des données fictives va vider toutes les tables
         */

        $faker = \Faker\Factory::create('fr_FR');


        for ($i = 0; $i < 20; $i++) {

            $entity = new Language();

            $entity->setName($faker->languageCode);


            /*
             * addReference
             *      - stocke l'entité en mémoire
             *      - permet d'utiliser l'entité dans une relationentre entités
             */

            $manager->persist($entity);

            $this->addReference('language '.$i, $entity);
        }

        $manager->flush();
    }
}