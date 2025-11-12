<?php

namespace S4mpp\Backline\Traits;

trait CanChangeCase
{
    private bool $uppercase = false;

    public function getIsUppercase(): bool
    {
        return $this->uppercase;
    }

    public function uppercase(): self
    {
        $this->uppercase = true;

        return $this;
    }
}
