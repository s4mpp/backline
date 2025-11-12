<?php

namespace S4mpp\Backline\Form;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Config;

final class File extends FormInput
{
    private $is_public = false;

    private $max_size_mb = 2;

    private $max_width = null;

    private $max_height = null;

    private string $accept = '*';

    private string $folder = '';

    private string $disk;

    public function __construct(string $title, string $name)
    {
        parent::__construct($title, $name);

        $this->addRule('file');

        $this->setComponent('backline::form.file');

        $this->disk = Config::get('filesystems.default');
    }

    public function image(int $max_width, int $max_height)
    {
        $this->max_width = $max_width;
        $this->max_height = $max_height;

        $this->accept = 'image/*';

        $this->addRule('image', Rule::dimensions()->maxWidth($max_width)->maxHeight($max_height));

        return $this;
    }

    public function folder(string $folder)
    {
        $this->folder = $folder;

        return $this;
    }

    public function getFolder(): string
    {
        return $this->folder;
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

    public function public()
    {
        $this->is_public = true;

        return $this;
    }

    public function isPublic(): bool
    {
        return $this->is_public;
    }

    public function maxSize(float $max_size_mb)
    {
        $this->max_size_mb = $max_size_mb = max($max_size_mb, 0);

        $max_kb = ceil($max_size_mb * 1024);

        $this->addRule('max:'.$max_kb);

        return $this;
    }

    public function getMaxFileSize(): string
    {
        return $this->max_size_mb.' MB';
    }

    public function getMaxDimensions(): ?string
    {
        if (! $this->max_width || ! $this->max_height) {
            return null;
        }

        return $this->max_width.'px de largura por '.$this->max_height.'px de altura';
    }

    public function getAcceptableFileTypes(): string
    {
        return $this->accept;
    }
}
