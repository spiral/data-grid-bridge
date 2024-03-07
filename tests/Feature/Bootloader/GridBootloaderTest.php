<?php

declare(strict_types=1);

namespace Spiral\Tests\DataGrid\Feature\Bootloader;

use Spiral\Config\ConfigManager;
use Spiral\Config\LoaderInterface;
use Spiral\DataGrid\Bootloader\GridBootloader;
use Spiral\DataGrid\Compiler;
use Spiral\DataGrid\Config\GridConfig;
use Spiral\DataGrid\Grid;
use Spiral\DataGrid\GridFactory;
use Spiral\DataGrid\GridFactoryInterface;
use Spiral\DataGrid\GridInput;
use Spiral\DataGrid\GridInterface;
use Spiral\DataGrid\InputInterface;
use Spiral\DataGrid\Response\GridResponse;
use Spiral\DataGrid\Response\GridResponseInterface;
use Spiral\Testing\Attribute\TestScope;
use Spiral\Tests\DataGrid\Feature\TestCase;

final class GridBootloaderTest extends TestCase
{
    public function testInputInterfaceBindingInRootScope(): void
    {
        $this->assertContainerBoundAsSingleton(InputInterface::class, InputInterface::class);
    }

    #[TestScope('http.request')]
    public function testGridInputInHttpRequestScope(): void
    {
        $this->assertContainerBoundAsSingleton(InputInterface::class, GridInput::class);
    }

    public function testGridInterfaceBinding(): void
    {
        $this->assertContainerBoundAsSingleton(GridInterface::class, Grid::class);
    }

    public function testGridFactoryInterfaceBinding(): void
    {
        $this->assertContainerBoundAsSingleton(GridFactoryInterface::class, GridFactory::class);
    }

    public function testCompilerBinding(): void
    {
        $this->assertContainerBoundAsSingleton(Compiler::class, Compiler::class);
    }

    public function testGridResponseInterfaceBinding(): void
    {
        $this->assertContainerBoundAsSingleton(GridResponseInterface::class, GridResponse::class);
    }

    public function testDefaultConfig(): void
    {
        $this->assertConfigMatches(GridConfig::CONFIG, ['writers' => []]);
    }

    public function testAddWriter(): void
    {
        $loader = $this->createMock(LoaderInterface::class);
        $loader->method('has')->willReturn(true);
        $loader->method('load')->willReturn(['writers' => []]);

        $configManager = new ConfigManager($loader);

        $this->assertSame(['writers' => []], $configManager->getConfig(GridConfig::CONFIG));

        $bootloader = new GridBootloader($configManager, $this->getContainer());
        $bootloader->addWriter('foo');
        $bootloader->addWriter('bar');

        $this->assertSame(['writers' => ['foo', 'bar']], $configManager->getConfig(GridConfig::CONFIG));
    }
}
