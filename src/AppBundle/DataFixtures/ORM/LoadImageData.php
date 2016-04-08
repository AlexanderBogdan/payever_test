<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Image;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadImageData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $albums = $manager->getRepository('AppBundle\Entity\Album')->findAll();
        foreach($albums as $key => $album) {
            $image_count = ($key === 0) ? 5 : rand(20, 100);
            for ($i = 1; $i <= $image_count; $i++) {
                $image = new Image();
                $image->setTitle('Image #' . $i);
                $image->setAlt('Alt text of image #' . $i);
                $image->setUrl('http://placehold.it/150x150');
                $image->setAlbum($album);
                $manager->persist($image);

                // Batch save every 20 images
                if ($i % 20 === 0) {
                    $manager->flush();
                }
            }
            // final flush
            $manager->flush();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}