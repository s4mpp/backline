<?php

namespace S4mpp\Backline\Builders;

use Closure;
use S4mpp\Backline\Enums\Action;
use S4mpp\Backline\Form\FormInput;
use S4mpp\Backline\Concerns\Resource;

class FormBuilder
{
    private array $group_fields = [];

    private ?string $current_group = null;

    private ?Closure $validation = null;

    private ?int $id = null;

    public function __construct(private ?Action $action = null) {}

    public function collect(Resource $resource)
    {
        if (method_exists($resource, 'form')) {

            $resource->form($this);
        }

        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function isCreating()
    {
        return $this->action == Action::Create;
    }

    public function isUpdating()
    {
        return $this->action == Action::Update;
    }

    public function group(string $name_group)
    {
        $this->current_group = $name_group;

        return $this;
    }

    public function fields(FormInput ...$fields): void
    {
        $this->group_fields[$this->current_group] = array_merge($this->group_fields[$this->current_group] ?? [], $fields);

        $this->current_group = null;
    }

    public function getGroups()
    {
        return $this->group_fields;
    }

    public function getItems(?callable $filter = null): array
    {
        $fields = [];

        foreach ($this->group_fields as $group) {
            foreach ($group as $field) {
                if ($filter === null || $filter($field)) {
                    $fields[] = $field;
                }
            }
        }

        return $fields;
    }

    public function afterValidation(Closure $validation): void
    {
        $this->validation = $validation;
    }

    public function getAfterValidation()
    {
        return $this->validation;
    }
}
