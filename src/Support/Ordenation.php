<?php

namespace S4mpp\Backline\Support;

final class Ordenation
{
    // TODO metodo ->desc()  ->asc()
    public function __construct(private ?string $ordenation_field = null, private ?string $ordenation_direction = null) {}

    final public function getField(): string
    {
        return $this->ordenation_field;
    }

    final public function getDirection(): string
    {
        return $this->ordenation_direction;
    }

    /**
     * @return array<string>
     */
    final public function toArray(): array
    {
        return [$this->ordenation_field => $this->ordenation_direction];
    }
}
