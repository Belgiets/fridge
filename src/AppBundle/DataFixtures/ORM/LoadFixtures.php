<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Food;
use AppBundle\Entity\Category;
use AppBundle\Entity\Item;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $objects = Fixtures::load(__DIR__.'/fixtures.yml', $manager);
    }
}