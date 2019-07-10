<?php

declare(strict_types=1);

namespace App\Dto;

/**
 * Class ClassroomDto.
 */
class ClassroomDto
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var bool
     */
    private $active;

    /**
     * ClassroomDto constructor.
     * @param string $name
     * @param bool $active
     */
    public function __construct(string $name, bool $active)
    {
        $this->name = $name;
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return ClassroomDto
     */
    public function setName(string $name): ClassroomDto
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
     * @return ClassroomDto
     */
    public function setActive(bool $active): ClassroomDto
    {
        $this->active = $active;

        return $this;
    }
}