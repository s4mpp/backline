<?php

namespace S4mpp\Backline\Labels;

use Illuminate\Support\Number;
use S4mpp\Backline\Traits\CanSum;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

final class Currency extends Label
{
    use CanSum;

    public function __construct(string $title, ?string $field = null, private bool $convert_cents = false)
    {
        parent::__construct($title, $field);

        $this->align('right');
    }

    public function getContentFormatted(): ?string
    {
        $value = $this->getContentAfterCallbacks();

        if (!is_numeric($value)) {
            return null;
        }

        return Number::currency($value);
    }

    // public function getValueToXLSX()
    // {
    //     return $this->getRawValue();
    // }

    // public function getValueToCSV()
    // {
    //     return $this->getRawValue();
    // }

    //TODO currency do NUmber locale
    // public function formatExcel(): string
    // {
    //     return '"R$" #,##0.00_-';
    // }

    public function getOriginalContent(): mixed
    {
        $value = parent::getOriginalContent();

        if ($this->convert_cents) {
            $value /= 100;
        }

        return $value;
    }
}
