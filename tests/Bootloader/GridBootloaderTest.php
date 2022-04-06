<?php

declare(strict_types=1);

namespace Spiral\Tests\DataGrid\Bootloader;

use PHPUnit\Framework\TestCase;
use Spiral\Config\ConfigManager;
use Spiral\Config\LoaderInterface;
use Spiral\DataGrid\Bootloader\GridBootloader;
use Spiral\DataGrid\Config\GridConfig;

final class GridBootloaderTest extends TestCase
{
    public function testAddWriter(): void
    {
        $loader = $this->createMock(LoaderInterface::class);
        $loader->method('has')->willReturn(true);
        $loader->method('load')->willReturn(['writers' => []]);

        $configManager = new ConfigManager($loader);

        $this->assertSame(['writers' => []], $configManager->getConfig(GridConfig::CONFIG));

        $bootloader = new GridBootloader($configManager);
        $bootloader->addWriter('foo');
        $bootloader->addWriter('bar');

        $this->assertSame(['writers' => ['foo', 'bar']], $configManager->getConfig(GridConfig::CONFIG));
    }
}
