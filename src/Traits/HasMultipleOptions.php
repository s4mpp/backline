<?php

namespace S4mpp\Backline\Traits;

use Closure;
use Illuminate\Database\Eloquent\Collection as DatabaseCollection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Database\Eloquent\Model;

// TODO [MAJOR] add method Model (major) - select only fields are used (key and value)
// TODO [MAJOR] create methods: key and value (add callback automatically)
trait HasMultipleOptions
{
    // /**
    //  * @var array<mixed>|SupportCollection<int,string|int>|DatabaseCollection
    //  */
    // private array|SupportCollection|DatabaseCollection $options = [];

    private Closure $get_source;

    private ?Closure $callback_key = null;

    private ?Closure $callback_value = null;

    public function source(Closure $get_source)
    {
        $this->get_source = $get_source;

        return $this;
    }

    public function key($callback_key)
    {
        $this->callback_key = $callback_key;
    }

    public function value($callback_value)
    {
        $this->callback_value = $callback_value;
    }

    /**
     * @return array<string|null>
     */
    public function getOptions()
    {
        $options = [];

        $source = call_user_func($this->get_source);

        foreach ($source as $key => $value) {

            if($this->callback_key) {
                $new_key = call_user_func($this->callback_key, $value, $key);

                if(!is_null($new_key))
                {
                    $key = $new_key;
                }
            }

            if($this->callback_value) {
                $value = call_user_func($this->callback_value, $value, $key);
            }

            if(is_array($value)) {
                $value = json_encode($value);
            }

            $options[$key] = $value;
        }

        return $options;
    }

    public function fromModel(string $model_class, ?string $value = null, string $key = 'id')
    {
        $this->source(fn() => $model_class::get());

        $this->key(function($item) use ($key) {

            if(!$item->{$key}) {
                throw new \Exception('Chave '.$key.' não existe na coleção');
            }

            return $item->{$key};
        });

        $this->value(fn($item) => $item[$value] ?? join(' | ', array_filter($item->toArray())));

        return $this;
    }

    public function fromEnum(string $enum_class, ?string $value = null, ?string $key = null)
    {
        $this->source(fn() => $enum_class::cases());

        $this->key(function($item) use ($key) {

            if (is_string($key)) {
                return $item->$key();
            }

            return $item->value;
        });

        $this->value(function($item) use ($value) {
            if (is_string($value)) {
                return $item->$value();
            }

            return $item->name;
        });

        return $this;
    }

    // public function enum(string $enum_class, Closure|string|null $get_key = null, Closure|string|null $get_value = null): self
    // {
    //     $this->options = $enum_class::cases();

    //     $this->setkey($get_key, function ($get_key) {
    //         if (is_string($get_key)) {
    //             return fn ($value) => $value->$get_key();
    //         }

    //         return fn ($value) => $value->value;
    //     });

    //     $this->setValue($get_value, function ($get_value) {
    //         if (is_string($get_value)) {
    //             return fn ($value) => $value->$get_value();
    //         }

    //         return fn ($value) => $value->name;
    //     });

    //     return $this;
    // }



    // private Closure $callback_key;

    // private Closure $callback_value;

    // /**
    //  * @return array<string|null>
    //  */
    // public function getOptions()
    // {
    //     foreach ($this->options as $key => $value) {
    //         $key = call_user_func($this->callback_key, $value, $key);

    //         $value = call_user_func($this->callback_value, $value, $key);

    //         $options[$key] = $value;
    //     }

    //     return $options ?? [];
    // }

    // /**
    //  * @param  array<mixed>|SupportCollection<int,string|int>|DatabaseCollection  $options
    //  */
    // public function options(array|SupportCollection|DatabaseCollection $options, Closure|string|null $get_key = null, Closure|string|null $get_value = null): self
    // {
    //     $this->options = $options;

    //     $this->setKey($get_key, function ($get_key) {
    //         return function (mixed $value, mixed $key) use ($get_key) {
    //             if (is_string($value)) {
    //                 return $key;
    //             }

    //             if (is_array($value)) {
    //                 return $get_key ? $value[$get_key] : $key;
    //             }

    //             if (is_a($value, Model::class)) {
    //                 return $get_key ? $value->{$get_key} : $value->id;
    //             }
    //         };
    //     });

    //     $this->setValue($get_value, function ($get_value) {
    //         return function (mixed $value) use ($get_value) {
    //             if (is_string($value)) {
    //                 return $value;
    //             }

    //             if (is_array($value)) {
    //                 return $value[$get_value] ?? json_encode($value);
    //             }

    //             if (is_a($value, Model::class)) {
    //                 return $value[$get_value] ?? $value;
    //             }
    //         };
    //     });

    //     return $this;
    // }

    // public function enum(string $enum_class, Closure|string|null $get_key = null, Closure|string|null $get_value = null): self
    // {
    //     $this->options = $enum_class::cases();

    //     $this->setkey($get_key, function ($get_key) {
    //         if (is_string($get_key)) {
    //             return fn ($value) => $value->$get_key();
    //         }

    //         return fn ($value) => $value->value;
    //     });

    //     $this->setValue($get_value, function ($get_value) {
    //         if (is_string($get_value)) {
    //             return fn ($value) => $value->$get_value();
    //         }

    //         return fn ($value) => $value->name;
    //     });

    //     return $this;
    // }

    // private function setkey(Closure|string|null $default_get_key = null, Closure $alternative_get_key): void
    // {
    //     if (! is_string($default_get_key) && is_callable($default_get_key)) {
    //         $this->callback_key = $default_get_key;

    //         return;
    //     }

    //     $this->callback_key = $alternative_get_key($default_get_key);
    // }

    // private function setValue(Closure|string|null $default_get_value = null, Closure $alternative_get_value): void
    // {
    //     if (! is_string($default_get_value) && is_callable($default_get_value)) {
    //         $this->callback_value = $default_get_value;

    //         return;
    //     }

    //     $this->callback_value = $alternative_get_value($default_get_value);
    // }
}
