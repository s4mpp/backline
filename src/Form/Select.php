<?php

namespace S4mpp\Backline\Form;

use S4mpp\Backline\Traits\CanChangeCase;
use S4mpp\Backline\Traits\HasMultipleOptions;
use S4mpp\Backline\Traits\InputCanBeAutomatable;

final class Select extends FormInput
{
    // use CanChangeCase, HasMultipleOptions, InputCanBeAutomatable;
    use HasMultipleOptions;

    public function __construct(string $title, string $name)
    {
        parent::__construct($title, $name);

        $this->setComponent('backline::form.select');
    }

    // TODO duplicated
    // public function getContentDescription($value, bool $show_value = true)
    // {
    //     $options = $this->getOptions();

    //     $description = $options[$value] ?? null;

    //     if (! $description) {
    //         return null;
    //     }

    //     if (! $show_value) {
    //         return $description;
    //     }

    //     return $value.': '.$description;
    // }
}
