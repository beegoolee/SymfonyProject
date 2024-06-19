<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;
use App\Service\TimeFormatter;

class FormatterRuntime implements RuntimeExtensionInterface
{
    private TimeFormatter $formatter;

    public function __construct(TimeFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    public function timestampToString(string $timestamp, string $format = "d M, H:i"): string
    {
        return $this->formatter->getFormattedTime($timestamp, $format);
    }
}
