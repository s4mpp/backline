<?php

namespace S4mpp\Backline\Traits;

use S4mpp\AdminPanel\Utils\Alpine;

trait InteractsWithFormFieldSearch
{
    private bool $multiple = false;

    private ?string $model = null;

    private array $field_search_in = [];

    private string $label = 'id';

    private ?string $description = null;

    public function __construct(string $title, string $field)
    {
        parent::__construct($title, $field);

        $this->setComponent('backline::form.search');
    }

    public function label(string $label, string $description)
    {
        $this->label = $label;

        $this->description = $description;

        return $this;
    }

    // public function getLabel()
    // {
    //     return $this->label;
    // }

    // public function getLabelRegister(int|string|null $id = null)
    // {
    //     if (! $id) {
    //         return null;
    //     }

    //     $field = $this->label ?? 'id';

    //     if (! $this->model) {
    //         // TODO criar AdminPanelException
    //         throw new \Exception('Model não informado no Input Search ('.self::getTitle().' / '.self::getFieldName().')');
    //     }

    //     return app($this->model)::withoutGlobalScopes()->select('id', $field)->find($id)->{$field};
    // }

    // public function getSubTitle()
    // {
    //     return $this->subtitle;
    // }

    public function fromModel(string $model, string ...$field)
    {
        $this->model = $model;

        $this->field_search_in = $field;

        return $this;
    }

    // public function getModel(): ?string
    // {
    //     return $this->model;
    // }

    // public function getSearchIn(): array
    // {
    //     return $this->field_search_in;
    // }

    public function multiple()
    {
        $this->multiple = true;

        return $this;
    }

    public function isMultiple()
    {
        return $this->multiple;
    }

    // public function getData($value_selected)
    // {
    //     $items = [];

    //     if($value_selected)  {
    //         $items[ ]= [
    //             'id' => $value_selected,
    //             'label' => $this->getLabelRegister($value_selected),
    //         ];
    //     }

    //     return $items;
    // }

    // public function getAlpineDataInputs(array|string|null $value_selected)
    // {
    //     if (! $this->isMultiple()) {
    //         return [];
    //     }

    //     $data_inputs = [];

    //     foreach ($value_selected ?? [] as $value) {

    //         $label_selected = $this->getLabelRegister($value);

    //         $data_inputs[] = '{'.implode(', ', [Alpine::parse('id', intval($value)), Alpine::parse('label', $label_selected)]).'}';
    //     }

    //     return $data_inputs;
    // }

    // public function getAlpineDataInput(array|string|null $value_selected)
    // {
    //     if ($this->isMultiple()) {
    //         return [Alpine::parse('id', null), Alpine::parse('label', null)];
    //     }

    //     $label_selected = $this->getLabelRegister($value_selected);

    //     return [Alpine::parse('id', $value_selected), Alpine::parse('label', $label_selected)];
    // }
}
