<?php

namespace App\DataFixtures;

use App\Entity\Bibliothecque;
use App\Entity\Livre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $biblio1 = new Bibliothecque();
        $biblio1->setNomBiblio("Versailles");
        $manager->persist($biblio1);

        $biblio2 = new Bibliothecque();
        $biblio2->setNomBiblio("Mitterrand");
        $manager->persist($biblio2);

         $livre = new Livre();
         $livre->setTitreLivre("Tour du monde en 80 jours")
             ->setGenreLivre("adventure")
             ->setDateLivre(new \DateTime("2003-03-04"))
             ->setNoteLivre(5)
             ->setBibliothecque($biblio1)
             ->setCommentaireLivre("Très bien");
         $manager->persist($livre);

        $livre2 = new Livre();
        $livre2->setTitreLivre("Tintin et 7 boules de cristal")
            ->setGenreLivre("adventure")
            ->setBibliothecque($biblio2)
            ->setDateLivre(new \DateTime("1993-06-12"));
        $manager->persist($livre2);

        $manager->flush();
    }
}
