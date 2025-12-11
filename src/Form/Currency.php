<?php

namespace S4mpp\Backline\Form;

use Illuminate\Support\Number;
use S4mpp\AdminPanel\Traits\CanModifyFormInput;
use S4mpp\AdminPanel\Traits\InputCanBeAutomatable;

final class Currency extends FormInput
{
    // TODO min max (igual number)
    // use CanModifyFormInput;
    // use InputCanBeAutomatable;

    private bool $convert_cents = false;

    public function __construct(string $title, string $name)
    {
        parent::__construct($title, $name);

        $this->addRule('numeric');

        $this->setComponent('backline::form.input');
    }

    public function convertCents(): self
    {
        $this->convert_cents = true;

        return $this;
    }

    public function prepareForForm(mixed $data): mixed
    {
        if ($this->convert_cents) {
            $data /= 100;
        }

        return number_format($data, 2, ',', '.');
    }

    public function prepareForValidation(mixed $data): int|float|string|null
    {
        $number_float = str_replace(['.', ','], ['', '.'], $data);

        if ($this->convert_cents && $number_float && is_numeric($number_float)) {
            return intval($number_float * 100);
        }

        if (! $number_float) {
            return null;
        }

        return floatval($number_float);
    }

    // public function getContentDescription($value)
    // {
    //     if ($this->convert_cents) {
    //         $value /= 100;
    //     }

    //     return Number::currency($value);
    // }

    /**
     * @return array<string|null>
     */
    public function getAttributes(): array
    {
        return [
            'type' => 'text',
            'x-mask:dynamic' => '$money($input, ",", ".")',
        ];
    }
}
