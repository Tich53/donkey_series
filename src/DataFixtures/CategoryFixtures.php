<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public const CATEGORY_ACTION = "Action";
    public const CATEGORY_COMEDIE = "Comédie";
    public const CATEGORY_DOCUMENTAIRE = "Documentaire";
    public const CATEGORY_FANTASTIQUE = "Fantastique";
    public const CATEGORY_THRILLER = "Thriller";
    public const CATEGORY_HORREUR = "Horreur";

    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName('Action');
        $this->addReference(self::CATEGORY_ACTION, $category);
        $manager->persist($category);

        $category = new Category();
        $category->setName('Comédie');
        $this->addReference(self::CATEGORY_COMEDIE, $category);
        $manager->persist($category);

        $category = new Category();
        $category->setName('Documentaire');
        $this->addReference(self::CATEGORY_DOCUMENTAIRE, $category);
        $manager->persist($category);

        $category = new Category();
        $category->setName('Fantastique');
        $this->addReference(self::CATEGORY_FANTASTIQUE, $category);
        $manager->persist($category);

        $category = new Category();
        $category->setName('Thriller');
        $this->addReference(self::CATEGORY_THRILLER, $category);
        $manager->persist($category);

        $category = new Category();
        $category->setName('Horreur');
        $this->addReference(self::CATEGORY_HORREUR, $category);
        $manager->persist($category);

        $manager->flush();
    }
}
