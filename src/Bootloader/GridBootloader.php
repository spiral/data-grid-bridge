<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace Spiral\DataGrid\Bootloader;

use Spiral\Boot\Bootloader\Bootloader;
use Spiral\DataGrid\Compiler;
use Spiral\DataGrid\Grid;
use Spiral\DataGrid\GridFactory;
use Spiral\DataGrid\GridInput;
use Spiral\DataGrid\GridInterface;
use Spiral\DataGrid\InputInterface;
use Spiral\DataGrid\Writer\QueryWriter;

final class GridBootloader extends Bootloader
{
    protected const SINGLETONS = [
        InputInterface::class => GridInput::class,
        GridInterface::class  => Grid::class,
        GridFactory::class    => GridFactory::class,
        Compiler::class       => [self::class, 'compiler']
    ];

    /**
     * @return Compiler
     */
    public function compiler(): Compiler
    {
        $compiler = new Compiler();
        $compiler->addWriter(new QueryWriter());

        return $compiler;
    }
}