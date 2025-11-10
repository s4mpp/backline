<?php

namespace S4mpp\Backline\Traits;

trait HasDefaultValue
{
    private string|int|float|null $default_value = null;

    public function getDefaultValue(): ?string
    {
        return $this->default_value ?? null;
    }

    public function default(string|int|float $text): self
    {
        $this->default_value = $text;

        return $this;
    }
}
