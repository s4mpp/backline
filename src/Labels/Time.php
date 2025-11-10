<?php

namespace S4mpp\Backline\Labels;

use Closure;
use Illuminate\Support\Carbon;
use S4mpp\AdminPanel\Traits\Strongable;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use S4mpp\AdminPanel\Traits\HasComponent;
use S4mpp\AdminPanel\Traits\HasDefaultValue;

final class Time extends Label
{
    // use Strongable;
    // use HasComponent, HasDefaultValue;

    public function __construct(string $title, ?string $field = null, private string $format = 'd/m/Y H:i')
    {
        parent::__construct($title, $field);

        // $this->setComponent('admin::label.datetime');
    }

    public function date()
    {
        $this->format = 'd/m/Y';

        return $this;
    }

    public function format(string $format)
    {
        $this->format = $format;

        return $this;
    }

    public function getContentFormatted(): ?string
    {
        $date = $this->getContentAfterCallbacks();

        /** @var object|string|null $date */
        if (is_a($date, Carbon::class)) {
            return $date->format($this->format);
        }

        if (! $date) {
            return null;
        }

        $time = strtotime(strval($date));

        $year = intval(date('Y', $time));

        $month = intval(date('m', $time));

        $day = intval(date('d', $time));

        if (! checkdate($month, $day, $year)) {
            return null;
        }

        return date($this->format, $time);
    }

    // public function getDiffForHumans(): ?string
    // {
    //     $datetime = $this->getValue();

    //     /** @var object $datetime */
    //     if (is_a($datetime, Carbon::class)) {
    //         return $datetime->diffForHumans();
    //     }

    //     return null;
    // }

    // public function formatExcel(): ?string
    // {
    //     return $this->format_excel;
    // }

    // public function mapExcel(): Closure
    // {
    //     return function ($data) {
    //         $datetime = \DateTime::createFromFormat($this->from_format, $data);

    //         if (! $datetime) {
    //             return null;
    //         }

    //         return Date::dateTimeToExcel($datetime);
    //     };
    // }

    // public function getValueToXLSX()
    // {
    //     $value = $this->getValue();

    //     return $value;
    // }
}
