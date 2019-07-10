<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Yaml\Yaml;

abstract class AbstractLoadFixturesData extends Fixture
{
    /**
     * Return the fixtures for the current model.
     *
     * @param string $fileName
     *
     * @return array
     */
    public function getModelFixtures($fileName)
    {
        $filePath = __DIR__.'/Data/'.$fileName.'.yaml';

        $content = file_get_contents($filePath);

        return Yaml::parse($content);
    }
}