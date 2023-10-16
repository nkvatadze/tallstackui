<?php

namespace TallStackUi\View\Personalizations\Components;

use TallStackUi\View\Components\Avatar\Avatar as Component;
use TallStackUi\View\Personalizations\Contracts\Personalizable;
use TallStackUi\View\Personalizations\PersonalizationResource;

/**
 * @internal This class is not meant to be used directly.
 */
class Avatar extends PersonalizationResource implements Personalizable
{
    protected function component(): string
    {
        return Component::class;
    }
}