<?php
/**
 * Created by PhpStorm.
 * User: wabap2-13
 * Date: 10/01/18
 * Time: 10:22
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\Contact;
use AppBundle\Entity\Country;
use AppBundle\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ContactFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        /*
         * utilisation des entités
         * $nanager équivant à doctrine
         * chaque insertion des données fictives va vider toutes les tables
         */

        $faker = \Faker\Factory::create('fr_FR');


        for ($i = 0; $i < 500; $i++) {

            $entity = new Contact();

            $entity->setFirstname($faker->firstName);
            $entity->setLastname($faker->lastName);
            $entity->setEmail($faker->email);
            $entity->setMessage($faker->text);

            /*
             * getReference : récupérer une réfrence créée dans une autre classe
             *      - recommandé : utiliser la méthode getDependencies qui permet de gérer l'ordre de création des objets
             */

            $entity->setCountry(
                $this->getReference('pays '.mt_rand(0, 19))
            );


            //for ($j = 0; $j < 3; $j++) {
                $entity->addLanguage(
                    $this->getReference('language 1')
                );
            //}


            $manager->persist($entity);

        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CountryFixtures::class,
            LanguageFixtures::class
        );
    }
}