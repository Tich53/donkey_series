<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName('Action');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Comédie');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Documentaire');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Fantastique');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Thriller');
        $manager->persist($category);

        $category = new Category();
        $category->setName('Horreur');
        $manager->persist($category);

        $manager->flush();
    }
}
