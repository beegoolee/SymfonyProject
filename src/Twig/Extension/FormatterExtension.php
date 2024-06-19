<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\FormatterRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class FormatterExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('filter_name', [FormatterRuntime::class, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('timestampToString', [FormatterRuntime::class, 'timestampToString'])
        ];
    }
}
