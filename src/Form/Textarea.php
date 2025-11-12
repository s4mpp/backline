<?php

namespace S4mpp\Backline\Form;

use S4mpp\Backline\Traits\CanChangeCase;
use S4mpp\Backline\Traits\HasPlaceholder;
use S4mpp\Backline\Traits\InputCanBeAutomatable;

final class Textarea extends FormInput
{
    use CanChangeCase;
    // HasPlaceholder, InputCanBeAutomatable;
    // use HasPlaceholder;

    public function __construct(string $title, string $name, private int $rows = 4)
    {
        parent::__construct($title, $name);

        $this->setComponent('backline::form.textarea');
    }

    public function getRows(): int
    {
        return $this->rows;
    }

    /**
     * @return array<int|string>
     */
    public function getAttributes(): array
    {
        return [
            'rows' => $this->getRows(),
            // 'placeholder' => $this->getPlaceholder(),
        ];
    }
}
