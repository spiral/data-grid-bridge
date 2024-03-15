<?php

declare(strict_types=1);

namespace Spiral\Tests\DataGrid\Feature;

use Spiral\Core\Container;
use Spiral\Core\Options;
use Spiral\DataGrid\Bootloader\GridBootloader;

abstract class TestCase extends \Spiral\Testing\TestCase
{
    /**
     * Will be removed after spiral/core 4.0 release.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $options = new Options();
        $options->checkScope = true;

        if (static::MAKE_APP_ON_STARTUP) {
            $this->initApp(static::ENV, new Container(options: $options));
        }

        $this->setUpTraits();
    }

    public function defineBootloaders(): array
    {
        return [
            GridBootloader::class,
        ];
    }
}
