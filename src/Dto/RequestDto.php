<?php

declare(strict_types=1);

namespace App\Dto;

/**
 * Class RequestDto.
 */
class RequestDto
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
     * RequestDto constructor.
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
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}