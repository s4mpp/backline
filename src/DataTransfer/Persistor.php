<?php

namespace S4mpp\Backline\DataTransfer;

use Illuminate\Support\ValidatedInput;
use Illuminate\Database\Eloquent\Model;
use S4mpp\Backline\Builders\FormBuilder;
use Illuminate\Support\Facades\Validator;

final class Persistor
{
    private ?Model $register = null;

    public function __construct(private FormBuilder $builder, private Model $model, private array $data) {}

    public function setRegister(Model $register): void
    {
        $this->register = $register;
    }

    public function validate()
    {
        $data_to_validate = $validation_rules = $attributes = [];

        foreach ($this->builder->getItems() as $input) {
            $name = $input->getFieldName();


            $validation_rules[$name] = $input->getRules($this->data, $this->model->getTable(), $this->register?->getAttribute('id'));

            $attributes[$name] = $input->getTitle();

            $value = $this->data[$name];

            if (method_exists($input, 'prepareForValidation')) {
                $value = $input->prepareForValidation($value);
            }

            $data_to_validate[$name] = $input->prepareForSave($value);

        }

        $validator = Validator::make($data_to_validate, $validation_rules, [], $attributes);

        if ($after = $this->builder->getAfterValidation()) {
            $validator->after($after);
        }

        $validator->validate();

        return $validator->safe();
    }

    public function save(ValidatedInput $data): void
    {
        if (! $register = $this->register) {
            $register = new $this->model;
        }

        foreach ($this->builder->getItems() as $input) {

            $field_name = $input->getFieldName();

            $input_name = $field_name;

            $new_name = $data[$input_name] ?? null;

            $register->{$field_name} = $new_name;
        }

        $register->save();
    }
}
