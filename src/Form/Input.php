<?php

namespace S4mpp\Backline\Form;

use S4mpp\AdminPanel\Traits\CanChangeCase;
use S4mpp\AdminPanel\Traits\HasPlaceholder;
use S4mpp\AdminPanel\Traits\CanModifyFormInput;
use S4mpp\AdminPanel\Traits\InputCanBeAutomatable;

final class Input extends FormInput
{
    // // use CanChangeCase, CanModifyFormInput;
    // use CanChangeCase, HasPlaceholder, InputCanBeAutomatable;

    // // private ?string $mask = null;

    // // public function __construct(string $title, string $name)
    // // {
    // //     parent::__construct($title, $name);

    // //     $this->addRule('string');
    // // }

    private array $attributes = [];

    private string $type = 'text';

    // public function __construct(string $title, private string $name)
    // {
    //     parent::__construct($title, $name);

    //     $this->addRule('string');

    //     // $this->setComponent('admin::input.input');
    // }

    // public function email()
    // {
    //     $this->type = 'email';

    //     $this->addRule('email');

    //     return $this;
    // }

    // public function password()
    // {
    //     $this->type = 'password';

    //     // TODO rule min/max 64

    //     return $this;
    // }

    // public function date()
    // {
    //     $this->type = 'date';

    //     $this->callback(fn (?string $value) => ($value) ? date('Y-m-d', strtotime($value)) : null);

    //     return $this;
    // }

    // public function datetime()
    // {
    //     $this->type = 'datetime-local';

    //     $this->callback(fn (?string $value) => ($value) ? date('Y-m-d H:i', strtotime($value)) : null);

    //     return $this;
    // }

    // // TODO colocar step como 3. parametro
    // public function number(float|int $step = 1, float|int|null $min = null, float|int|null $max = null): self
    // {
    //     $this->type = 'number';

    //     $this->addRule('numeric');

    //     if ($step) {
    //         $this->attributes['step'] = max($step, 0);
    //     }

    //     if ($min) {
    //         $this->attributes['min'] = max($min, 0);
    //     }

    //     if ($max) {
    //         $this->attributes['max'] = min($max, 999999999);
    //     }

    //     return $this;
    // }

    // // public function mask(string $mask): self
    // // {
    // //     $this->mask = $mask;

    // //     return $this;
    // // }

    // // public function getMask(): ?string
    // // {
    // //     return $this->mask;
    // // }
    
    public function getType(): string
    {
        return $this->type;
    }

    // /**
    //  * @return array<string|null>
    //  */
    // public function getAttributes(): array
    // {
    //     return array_merge($this->attributes, [
    //         // 'x-mask' => $this->getMask(),
    //         'type' => $this->type,
    //         // 'placeholder' => $this->getPlaceholder(),
    //     ]);
    // }

    // // public function render()
    // // {
    // // 	return view('admin::input.text', ['input' => $this]);
    // // }
}
