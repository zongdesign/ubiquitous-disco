<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClassroomRepository")
 *
 * @JMS\ExclusionPolicy("all")
 *
 * @UniqueEntity("name")
 */
class Classroom
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @JMS\Groups({"classroom"})
     * @JMS\Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, unique=true)
     *
     * @JMS\Groups({"classroom"})
     * @JMS\Expose
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     *
     * @JMS\Groups({"classroom"})
     * @JMS\Expose
     */
    private $active = true;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Classroom
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return Classroom
     */
    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
