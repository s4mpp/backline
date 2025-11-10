<?php

namespace S4mpp\Backline\Labels;

use S4mpp\AdminPanel\Traits\Strongable;
use S4mpp\AdminPanel\Traits\HasComponent;

// TODO renomear para Markdown
final class MarkDown extends Label
{
    // use Strongable;
    // use HasComponent;

    public function __construct(string $title, ?string $field = null)
    {
        parent::__construct($title, $field);

        // $this->setComponent('admin::label.markdown');
    }
}
