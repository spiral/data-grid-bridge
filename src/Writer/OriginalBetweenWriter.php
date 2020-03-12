<?php
declare(strict_types=1);

namespace Spiral\DataGrid\Writer;

use Spiral\DataGrid\Compiler;
use Spiral\DataGrid\Specification\Filter;
use Spiral\DataGrid\SpecificationInterface;
use Spiral\DataGrid\WriterInterface;

class OriginalBetweenWriter implements WriterInterface
{
    /**
     * @inheritDoc
     */
    public function write($source, SpecificationInterface $specification, Compiler $compiler)
    {
        if ($specification instanceof Filter\Between || $specification instanceof Filter\ValueBetween) {
            $filters = $specification->getFilters(true);
            if (count($filters) > 1) {
                return $source->where(static function () use ($compiler, $source, $filters): void {
                    $compiler->compile($source, ...$filters);
                });
            }

            return $source->where(
                $specification instanceof Filter\Between ? $specification->getExpression() : $specification->getValue(),
                'BETWEEN',
                ...($specification instanceof Filter\Between ? $specification->getValue() : $specification->getExpression())
            );
        }

        return null;
    }
}
