<?php

namespace S4mpp\Backline\Form;

use S4mpp\Backline\Traits\CanBeInline;
use S4mpp\Backline\Traits\HasMultipleOptions;
use S4mpp\AdminPanel\Traits\InputCanBeAutomatable;

final class Radio extends FormInput
{
    // use CanBeInline, HasMultipleOptions, InputCanBeAutomatable;
    use CanBeInline, HasMultipleOptions;

    public function __construct(string $title, string $name)
    {
        parent::__construct($title, $name);

        $this->setComponent('backline::form.radio');
    }

    // //TODO duplicated
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

    public function boolean()
    {
        $this->source(fn () => [
            1 => 'Sim',
            0 => 'Não',
        ]);

        return $this;
    }
}
