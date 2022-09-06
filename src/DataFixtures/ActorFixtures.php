<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ActorFixtures extends Fixture
{
    const ACTOR_LEONARDO_DICAPRIO = "Leonardo DiCaprio";
    const ACTOR_QUENTIN_TARANTINO = "Quentin Tarantino";
    const ACTOR_CLINT_EASTWOOD = "Clint Eastwood";
    const ACTOR_TOM_CRUISE = "Tom Cruise";
    const ACTOR_JASON_STATHAM = "Jason Statham";




    public function load(ObjectManager $manager): void
    {
        $actor = new Actor();
        $actor->setName(self::ACTOR_LEONARDO_DICAPRIO);
        $manager->persist($actor);
        $this->addReference(self::ACTOR_LEONARDO_DICAPRIO, $actor);

        $actor = new Actor();
        $actor->setName(self::ACTOR_QUENTIN_TARANTINO);
        $manager->persist($actor);
        $this->addReference(self::ACTOR_QUENTIN_TARANTINO, $actor);

        $actor = new Actor();
        $actor->setName(self::ACTOR_CLINT_EASTWOOD);
        $manager->persist($actor);
        $this->addReference(self::ACTOR_CLINT_EASTWOOD, $actor);

        $actor = new Actor();
        $actor->setName(self::ACTOR_TOM_CRUISE);
        $manager->persist($actor);
        $this->addReference(self::ACTOR_TOM_CRUISE, $actor);

        $actor = new Actor();
        $actor->setName(self::ACTOR_JASON_STATHAM);
        $manager->persist($actor);
        $this->addReference(self::ACTOR_JASON_STATHAM, $actor);

        $manager->flush();
    }
}
