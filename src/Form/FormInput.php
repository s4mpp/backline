<?php

namespace S4mpp\Backline\Form;

use Closure;
use Illuminate\Validation\Rule;
use S4mpp\Backline\Traits\Titleable;
use Illuminate\Database\Eloquent\Model;
use S4mpp\AdminPanel\Traits\CanBeHidden;
use S4mpp\AdminPanel\Traits\HasCallbacks;
use S4mpp\AdminPanel\Traits\HasComponent;
use S4mpp\AdminPanel\Traits\HasDefaultText;
use S4mpp\AdminPanel\Traits\HasDefaultValue;
use Illuminate\Contracts\Validation\ValidationRule;

// TODO implement COntract com metodo getAttributes (nos filhos)
abstract class FormInput
{
    // use CanBeHidden, HasComponent, HasDefaultText, Titleable;
    // use HasCallbacks, HasComponent, HasDefaultValue, Titleable;
    use Titleable;

    // private ?string $prefix = 'data';

    private array $callback_preparation = [];

    // private ?string $description = null;

    private bool $is_required = true;

    // /**
    //  * @var int|array<int>|null
    //  */
    // protected int|array|null $initial_value = null;

    /**
     * @var array<mixed>
     */
    private array $rules = ['required'];

    private string|int|float|null $default_value = null;

    public function __construct(string $title, private string $field_name)
    {
        $this->setTitle($title);
    }

    final public function getFieldName(): string
    {
        return $this->field_name;
    }

    final public function getDefaultValue(): ?string
    {
        return $this->default_value ?? null;
    }

    final public function default(string|int|float $text): self
    {
        $this->default_value = $text;

        return $this;
    }

    public function prepareForForm(mixed $data)
    {
        if ($callback = $this->callback_preparation['get'] ?? null) {
            return $callback($data);
        }

        return $data;
    }

    public function prepareForSave(mixed $data)
    {
        if ($callback = $this->callback_preparation['set'] ?? null) {
            return $callback($data);
        }

        return $data;
    }

    // // public function getPreparationRules(string $action): ?Closure
    // // {
    // //     return $this->callback_preparation[$action] ?? null;
    // // }

    public function prepare(?Closure $get = null, ?Closure $set = null): self
    {
        $this->callback_preparation = compact('get', 'set');

        return $this;
    }

    // public function getDescription(): ?string
    // {
    //     return $this->description;
    // }

    // public function getOriginalContentDescription(Model $register)
    // {
    //     $value = $register->getRawOriginal($this->field_name);

    //     if (is_null($value)) {
    //         return null;
    //     }

    //     return $this->getContentDescription($value);
    // }

    // public function getNewContentDescription($value = null, bool $show_value = true)
    // {
    //     if (is_null($value)) {
    //         return null;
    //     }

    //     return $this->getContentDescription($value, $show_value);
    // }

    // public function getContentDescription($value)
    // {
    //     return $value;
    // }

    // // public function getNameWithPrefix(): string
    // // {
    // //     return implode('.', array_filter([$this->prefix, $this->name]));
    // // }

    // public function description(string $description): self
    // {
    //     $this->description = $description;

    //     return $this;
    // }

    // // /**
    // //  * @return int|array<int>|string|null
    // //  */
    // // public function getInitialValue(): int|array|string|null
    // // {
    // //     if ($default_text = $this->getDefaultText()) {
    // //         return $default_text;
    // //     }

    // //     return $this->initial_value;
    // // }

    /**
     * @return array<string|Rule>
     */
    public function getRules(array $register = [], string $table = '', ?int $id = null): array
    {
        // TODO adicionar regras aqui (se for required)

        foreach ($this->rules as $rule) {
            if (! is_string($rule) && is_callable($rule)) {
                $rule = $rule($register, $table, $id);
            }

            $rules[] = $rule;
        }

        return $rules ?? [];
    }

    // public function addRule(string|Closure|ValidationRule ...$rules): self
    // {
    //     foreach ($rules as $rule) {
    //         $this->rules[] = $rule;
    //     }

    //     return $this;
    // }

    // public function removeRule(string $rule): void
    // {
    //     $key = array_search($rule, $this->rules);

    //     if ($key !== false) {
    //         unset($this->rules[$key]);
    //     }
    // }

    // // public function isRequired(): bool
    // // {
    // //     return in_array('required', $this->rules);
    // // }

    // public function optional(): self
    // {
    //     $this->removeRule('required');

    //     $this->addRule('nullable');

    //     $this->is_required = false;

    //     return $this;
    // }

    public function isRequired(): bool
    {
        return $this->is_required;
    }

    // public function unique(callable $where = null): self
    // {
    //     $this->addRule(function(array $data, string $table, ?int $id = null) use ($where) {

    //         $rule = Rule::unique($table, $this->getFieldName())->ignore($id);

    //         if(is_callable($where)) {
    //             $rule = $rule->where($where);
    //         }

    //         return $rule;
    //     });

    //     return $this;
    // }
}
