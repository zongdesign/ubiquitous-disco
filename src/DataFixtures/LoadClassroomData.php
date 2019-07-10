<?php

namespace App\DataFixtures;

use App\Entity\Classroom;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ClassroomFixtures.
 */
class LoadClassroomData extends AbstractLoadFixturesData
{
    /**
     * @param ObjectManager $manager
     *
     * @throws \ReflectionException
     */
    public function load(ObjectManager $manager): void
    {
        $classrooms = $this->getModelFixtures('classroom');

        foreach ($classrooms as $data) {
            $classroom = (new Classroom())
                ->setName($data['name'])
                ->setActive($data['is_active']);

            $this->addReference($data['reference'], $classroom);
            $manager->persist($classroom);
        }

        $manager->flush();
    }

    /**
     * The order in which the fixtures for this model will be loaded.
     *
     * @return int
     */
    public function getOrder(): int
    {
        return 1;
    }
}