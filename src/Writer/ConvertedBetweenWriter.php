<?php

declare(strict_types=1);

namespace Spiral\DataGrid\Writer;

use Spiral\DataGrid\Compiler;
use Spiral\DataGrid\Specification\Filter;
use Spiral\DataGrid\SpecificationInterface;
use Spiral\DataGrid\WriterInterface;

class ConvertedBetweenWriter implements WriterInterface
{
    /**
     * @inheritDoc
     */
    public function write($source, SpecificationInterface $specification, Compiler $compiler)
    {
        if ($specification instanceof Filter\Between || $specification instanceof Filter\ValueBetween) {
            return $source->where(static function () use ($compiler, $source, $specification): void {
                $compiler->compile($source, ...$specification->getFilters());
            });
        }

        return null;
    }
}
