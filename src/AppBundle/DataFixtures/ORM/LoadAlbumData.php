<?php

namespace AppBundle\Bundle\DataFixtures\ORM;

use AppBundle\Entity\Album;
use AppBundle\Entity\Image;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadAlbumData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <=5; $i++) {
            $album = new Album();
            $album
                ->setTitle("Album #" . $i)
                ->setDescription("Description of album #" . $i);
            $manager->persist($album);
        }
        $manager->flush();
    }
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
