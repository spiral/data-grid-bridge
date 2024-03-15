<?php

declare(strict_types=1);

namespace Spiral\Tests\DataGrid\Unit\Config;

use PHPUnit\Framework\TestCase;
use Spiral\DataGrid\Config\GridConfig;

final class GridConfigTest extends TestCase
{
    public function testGetWriters(): void
    {
        $config = new GridConfig();
        $this->assertSame([], $config->getWriters());

        $config = new GridConfig(['writers' => ['foo', 'bar']]);
        $this->assertSame(['foo', 'bar'], $config->getWriters());
    }
}
