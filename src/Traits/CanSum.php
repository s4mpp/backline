<?php

namespace S4mpp\Backline\Traits;

trait CanSum
{
    private bool $has_sum = false;

    private ?string $field_sum = null;

    public function sum(?string $field = null): self
    {
        $this->has_sum = true;

        if ($field) {
            $this->field_sum = $field;
        }

        return $this;
    }

    public function hasSum(): bool
    {
        return $this->has_sum;
    }

    public function getFieldForSum(): ?string
    {
        return $this->field_sum;
    }
}
