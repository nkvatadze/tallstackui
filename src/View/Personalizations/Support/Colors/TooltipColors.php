<?php

namespace TallStackUi\View\Personalizations\Support\Colors;

use TallStackUi\Facades\TallStackUi;
use TallStackUi\View\Components\Tooltip;

class TooltipColors
{
    public function __invoke(Tooltip $tooltip): array
    {
        $colors = match ($tooltip->color) {
            'white' => 'gray',
            default => $tooltip->color,
        };

        $weight = match ($tooltip->color) {
            'white' => 300,
            'black' => null,
            default => 500,
        };

        return ['icon.color' => TallStackUi::tailwind()->set('text', $colors, $weight)->get()];
    }
}
