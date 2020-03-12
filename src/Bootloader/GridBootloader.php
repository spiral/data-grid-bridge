<?php

/**
 * Spiral Framework. Data Grid Bridge.
 *
 * @license MIT
 * @author  Anton Tsitou (Wolfy-J)
 * @author  Valentin Vintsukevich (vvval)
 */

declare(strict_types=1);

namespace Spiral\DataGrid\Bootloader;

use Psr\Container\ContainerInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Config\ConfiguratorInterface;
use Spiral\Database\DatabaseInterface;
use Spiral\DataGrid\Compiler;
use Spiral\DataGrid\Config\GridConfig;
use Spiral\DataGrid\Grid;
use Spiral\DataGrid\GridFactory;
use Spiral\DataGrid\GridInput;
use Spiral\DataGrid\GridInterface;
use Spiral\DataGrid\InputInterface;
use Spiral\DataGrid\Writer\ConvertedBetweenWriter;
use Spiral\DataGrid\Writer\QueryWriter;

final class GridBootloader extends Bootloader
{
    protected const SINGLETONS = [
        InputInterface::class => GridInput::class,
        GridInterface::class  => Grid::class,
        GridFactory::class    => GridFactory::class,
        Compiler::class       => [self::class, 'compiler']
    ];

    /** @var ConfiguratorInterface */
    private $config;

    /**
     * @param ConfiguratorInterface $config
     */
    public function __construct(ConfiguratorInterface $config)
    {
        $this->config = $config;
    }

    public function boot(): void
    {
        $this->config->setDefaults(GridConfig::CONFIG, [
            'writers' => [QueryWriter::class, ConvertedBetweenWriter::class]
        ]);
    }

    /**
     * @param ContainerInterface $container
     * @param Compiler           $compiler
     * @param GridConfig         $config
     * @return Compiler
     */
    public function compiler(ContainerInterface $container, Compiler $compiler, GridConfig $config): Compiler
    {
        if ($container->has(DatabaseInterface::class)) {
            foreach ($config->getWriters() as $writer) {
                $compiler->addWriter($container->get($writer));
            }
        }

        return $compiler;
    }
}
