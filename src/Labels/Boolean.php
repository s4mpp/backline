<?php

namespace S4mpp\Backline\Labels;

use S4mpp\AdminPanel\Traits\HasComponent;

final class Boolean extends Label
{
    // use HasComponent;

    public function __construct(string $title, ?string $field = null)
    {
        parent::__construct($title, $field);

        // $this->setComponent('admin::label.boolean');
    }

    public function getContentFormatted(): ?string
    {
        $value = $this->getContentAfterCallbacks();

        if (is_null($value)) {
            return null;
        }

        return $value ? 'Sim' : 'Não';
    }
}
