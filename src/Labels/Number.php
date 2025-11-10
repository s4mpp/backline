<?php

namespace S4mpp\Backline\Labels;

use S4mpp\Backline\Traits\CanSum;
use S4mpp\AdminPanel\Traits\Strongable;
use Illuminate\Support\Number as SupportNumber;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

final class Number extends Label
{
    use CanSum;
    // use CanSum, Strongable;

    // public function getValueFormatted(): ?string
    // {
    //     $value = $this->getValue();

    //     if (is_null($value)) {
    //         return null;
    //     }

    //     $number_formatted = SupportNumber::format($value);

    //     if ($number_formatted === false) {
    //         return null;
    //     }

    //     return $number_formatted;
    // }

    // public function formatExcel(): string
    // {
    //     return NumberFormat::FORMAT_NUMBER;
    // }
}
