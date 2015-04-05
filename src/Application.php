<?php

namespace Silly\Edition\Pimple;

use Pimple\Container;

/**
 * Silly CLI application using Pimple.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class Application extends \Silly\Application
{
    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN', Container $container = null)
    {
        parent::__construct($name, $version);

        $container = $container ?: new Container;

        $this->useContainer($container, true, true);
    }
}
