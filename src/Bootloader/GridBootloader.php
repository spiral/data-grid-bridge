<?php

declare(strict_types=1);

namespace Spiral\DataGrid\Bootloader;

use Psr\Container\ContainerInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Config\ConfiguratorInterface;
use Spiral\Config\Patch\Append;
use Spiral\DataGrid\GridFactoryInterface;
use Spiral\DataGrid\Compiler;
use Spiral\DataGrid\Config\GridConfig;
use Spiral\DataGrid\Grid;
use Spiral\DataGrid\GridFactory;
use Spiral\DataGrid\GridInput;
use Spiral\DataGrid\GridInterface;
use Spiral\DataGrid\InputInterface;
use Spiral\DataGrid\Response\GridResponse;
use Spiral\DataGrid\Response\GridResponseInterface;

final class GridBootloader extends Bootloader
{
    protected const SINGLETONS = [
        InputInterface::class        => GridInput::class,
        GridInterface::class         => Grid::class,
        GridFactoryInterface::class  => GridFactory::class,
        Compiler::class              => [self::class, 'compiler'],
        GridResponseInterface::class => GridResponse::class,
    ];

    public function __construct(
        private readonly ConfiguratorInterface $config
    ) {
    }

    public function init(): void
    {
        $this->config->setDefaults(GridConfig::CONFIG, [
            'writers' => []
        ]);
    }

    public function compiler(ContainerInterface $container, Compiler $compiler, GridConfig $config): Compiler
    {
        foreach ($config->getWriters() as $writer) {
            $compiler->addWriter($container->get($writer));
        }

        return $compiler;
    }

    /**
     * @psalm-param class-string $writer
     */
    public function addWriter(string $writer): void
    {
        $this->config->modify(GridConfig::CONFIG, new Append('writers', null, $writer));
    }
}
