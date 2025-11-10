<?php

namespace S4mpp\Backline\Labels;

use Illuminate\Support\Facades\Config;
use S4mpp\AdminPanel\Traits\HasComponent;

final class Image extends Label
{
    // use HasComponent;

    public string $disk;

    public function __construct(string $title, ?string $field = null)
    {
        parent::__construct($title, $field);

        // $this->setComponent('admin::label.image');

        $this->disk = Config::get('filesystems.default');
    }

    public function disk(string $disk)
    {
        $this->disk = $disk;

        return $this;
    }

    public function getDisk(): string
    {
        return $this->disk;
    }
}
