<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

declare(strict_types=1);

namespace Spiral\DataGrid\Bootloader;

use Psr\Container\ContainerInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Database\DatabaseInterface;
use Spiral\DataGrid\Compiler;
use Spiral\DataGrid\Grid;
use Spiral\DataGrid\GridFactory;
use Spiral\DataGrid\GridInput;
use Spiral\DataGrid\GridInterface;
use Spiral\DataGrid\InputInterface;
use Spiral\DataGrid\Response\GridResponse;
use Spiral\DataGrid\Response\GridResponseInterface;
use Spiral\DataGrid\Writer\QueryWriter;

final class GridBootloader extends Bootloader
{
    protected const SINGLETONS = [
        InputInterface::class        => GridInput::class,
        GridInterface::class         => Grid::class,
        GridFactory::class           => GridFactory::class,
        Compiler::class              => [self::class, 'compiler'],
        GridResponseInterface::class => GridResponse::class
    ];

    /**
     * @param ContainerInterface $container
     * @return Compiler
     */
    public function compiler(ContainerInterface $container): Compiler
    {
        $compiler = new Compiler();

        if ($container->has(DatabaseInterface::class)) {
            $compiler->addWriter(new QueryWriter());
        }

        return $compiler;
    }
}
