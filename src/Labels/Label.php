<?php

namespace S4mpp\Backline\Labels;

use Closure;
use Illuminate\Support\Str;
use S4mpp\AdminPanel\Elements\Group;
use S4mpp\Backline\Traits\Titleable;
use Illuminate\Database\Eloquent\Model;
use S4mpp\AdminPanel\Traits\CanBeHidden;
use S4mpp\AdminPanel\Traits\HasCallbacks;
use S4mpp\AdminPanel\Traits\HasComponent;
use S4mpp\Backline\Traits\HasDefaultValue;

// TODO implement method hideIf
// TODO $register / setRegister pode ser estatico
abstract class Label
{
    // use CanBeHidden, HasCallbacks, HasComponent, HasDefaultText, Titleable;
    // use HasCallbacks, HasDefaultValue,
    use HasDefaultValue, Titleable;

    /**
     * @var array<Closure>
     */
    private array $callbacks = [];

    private string $alignment = 'left';

    // private ?int $size_on_pdf = null;

    /**
     * @var Model|array<string,mixed>
     */
    private Model|array $register;

    // protected mixed $value;

    private bool $is_relationship = false;

    private array $path = [];

    private ?Closure $link = null;

    private bool $link_is_in_new_tab = false;

    private bool $is_sortable = false;

    private ?Closure $callback_details = null;

    // private bool $copiable = false;

    // // private bool $with_callback = false;

    // // private ?Closure $from = null;

    private mixed $original_content;

    private mixed $content_after_callbacks;

    public function __construct(string $title, private ?string $field = null)
    {
        $this->setTitle($title);

        if (is_string($field)) {
            $this->is_relationship = ! (mb_strpos($field, '.') === false);

            $this->path = explode('.', $field);
        }
    }

    final public function callback(Closure $callback): self
    {
        $this->callbacks[] = $callback;

        return $this;
    }

    // public function copiable(): self
    // {
    //     $this->copiable = true;

    //     return $this;
    // }

    // public function isCopiable(): bool
    // {
    //     return $this->copiable;
    // }

    // // public function from(Closure $from): self
    // // {
    // //     $this->from = $from;

    // //     return $this;
    // // }

    final public function sortable(): self
    {
        $this->is_sortable = true;

        return $this;
    }

    final public function isSortable(): bool
    {
        return $this->is_sortable;
    }

    // public function getCurrentSort(array $sort_config)
    // {
    //     if (in_array($this->field.':asc', $sort_config)) {
    //         return 'asc';
    //     }

    //     if (in_array($this->field.':desc', $sort_config)) {
    //         return 'desc';
    //     }

    //     return null;
    // }

    final public function details(Closure $callback_details): self
    {
        $this->callback_details = $callback_details;

        return $this;
    }

    final public function getDetails(): mixed
    {
        $callback = $this->callback_details;

        if (! $callback) {
            return null;
        }

        return call_user_func($callback, $this->original_content, $this->register);
    }

    // TODO callback_link null, colocar value do campo
    final public function link(Closure $callback_link, bool $link_is_in_new_tab = false): self
    {
        $this->link = $callback_link;

        $this->link_is_in_new_tab = $link_is_in_new_tab;

        return $this;
    }

    // public function hasLink(): bool
    // {
    //     return is_callable($this->link);
    // }

    // public function linkIsInNewTab(): bool
    // {
    //     return $this->link_is_in_new_tab;
    // }

    // public function getLinkUrl(Model|array|null $register = null): ?string
    // {
    //     if(!$this->link) {
    //         return '#';
    //     }

    //     $callback_link = $this->link;

    //     if(is_callable($callback_link)) {
    //         return $callback_link($this->getValue(), $register);
    //     }

    //     return null;

    // }

    // public function getSizeOnPdf(): ?int
    // {
    //     return $this->size_on_pdf;
    // }

    // public function sizeOnPdf(int $size_percent, bool $force = false): self
    // {
    //     if ($force || is_null($this->size_on_pdf)) {
    //         $this->size_on_pdf = max(0, $size_percent);
    //     }

    //     return $this;
    // }

    final public function getField(): ?string
    {
        return $this->field;
    }

    public function align(string $alignment): self
    {
        $this->alignment = in_array($alignment, ['left', 'center', 'right']) ? $alignment : null;

        return $this;
    }

    public function getAlignment(): ?string
    {
        return $this->alignment;
    }

    // // /**
    // //  * @deprecated
    // //  */
    // // public function getAlignmentPdf(): ?string
    // // {
    // //     if (! $this->alignment) {
    // //         return null;
    // //     }

    // //     return Str::substr(Str::ucfirst($this->alignment), 0, 1);
    // // }

    // // public function withCallback(bool $run = true)
    // // {
    // //     $this->with_callback = $run;

    // //     return $this;
    // // }

    // public function getFormattedContent(): mixed
    // {
    //     return $this->runCallbacks($this->value, $this->register);
    // }

    // public function getValueFormatted(): ?string
    // {
    //     return trim((string) $this->getValue());
    // }

    // public function getValueToXLSX()
    // {
    //     return $this->getValueFormatted();
    // }

    // public function getValueToCSV()
    // {
    //     return $this->getValueFormatted();
    // }

    // // public function setValue(mixed $content): self
    // // {
    // //     $this->value = $content;

    // //     return $this;
    // // }

    final public function setRegister($register): self
    {
        $this->register = $register;

        return $this;
    }

    // // public function setValueFromRegister(): self
    // // {
    // //     if ($this->isRelationship()) {
    // //         $path = explode('.', $this->getField());

    // //         $value = $this->register[$path[0]] ?? null;

    // //         array_shift($path);

    // //         foreach ($path as $node) {
    // //             $value = $value[$node] ?? null;
    // //         }

    // //         return $this->setValue($value);
    // //     }

    // //     if ($this->from) {
    // //         return $this->setValue(call_user_func($this->from, $this->register));
    // //     }

    // //     $field = $this->getField();

    // //     return $this->setValue($this->register[$field] ?? null);
    // // }

    final public function setContentFromRegister(): void
    {
        if (! $this->is_relationship) {
            $this->original_content = $this->register[$this->field] ?? null;

            return;
        }

        $path = $this->path;

        $value = $this->register[$path[0]] ?? null;

        array_shift($path);

        foreach ($path as $node) {
            $value = $value[$node] ?? null;
        }

        $this->original_content = $value;
    }

    final public function runCallbacks(): void
    {
        $content = $this->getOriginalContent();

        foreach ($this->callbacks as $callback) {
            $content = $callback($content, $this->register);
        }

        $this->content_after_callbacks = $content;
    }

    // public function setValueFromRegister(): self
    // {
    //     if ($this->is_relationship) {
    //         $path = explode('.', $this->field);

    //         $value = $this->register[$path[0]] ?? null;

    //         array_shift($path);

    //         foreach ($path as $node) {
    //             $value = $value[$node] ?? null;
    //         }
    //     } else {
    //         $value = $this->register[$this->field] ?? null;
    //     }

    //     // if ($this->from) {
    //     //     return $this->setValue(call_user_func($this->from, $register));
    //     // }

    //     // $field = $this->getField();

    //     $this->value = $value;

    //     return $this;
    // }

    // // /**
    // //  * @param  array<Label|Group>  $labels
    // //  * @return array<Text|Label>
    // //  */
    // // final public static function resolveEmptyLabelsOfRegister(array $labels, ?Model $register = null): array
    // // {
    // //     if (! empty($labels)) {
    // //         return $labels;
    // //     }

    // //     if (is_null($register)) {
    // //         return [];
    // //     }

    // //     foreach (array_keys($register->getAttributes()) as $key) {
    // //         $text_labels_from_attribute[] = new Text(Str::headline($key), $key);
    // //     }

    // //     return $text_labels_from_attribute ?? [];
    // // }

    // private function runCallbacks(mixed $content = null, Model|array|null $register = null): mixed
    // {
    //     foreach ($this->callbacks as $callback) {
    //         $content = $callback($content, $register);
    //     }

    //     return $content;
    // }

    final public function getContentAfterCallbacks(): mixed
    {
        return $this->content_after_callbacks;
    }

    public function getOriginalContent(): mixed
    {
        return $this->original_content;
    }

    public function getContentFormatted(): mixed
    {
        return $this->getContentAfterCallbacks();
    }
}
