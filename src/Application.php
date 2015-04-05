<?php

namespace Silly\Edition\Pimple;

use Interop\Container\Pimple\PimpleInterop;

/**
 * Silly CLI application using Pimple.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class Application extends \Silly\Application
{
    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN', PimpleInterop $container = null)
    {
        parent::__construct($name, $version);

        $container = $container ?: new PimpleInterop;

        $this->useContainer($container, true, true);
    }
}
