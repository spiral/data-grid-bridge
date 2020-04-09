<?php

/**
 * Spiral Framework. Data Grid Bridge.
 *
 * @license MIT
 * @author  Valentin Vintsukevich (vvval)
 */

declare(strict_types=1);

namespace Spiral\DataGrid\Writer;

use Spiral\DataGrid\Compiler;
use Spiral\DataGrid\Specification\Filter;
use Spiral\DataGrid\SpecificationInterface;
use Spiral\DataGrid\WriterInterface;

class BetweenWriter implements WriterInterface
{
    /** @var bool */
    private $asOriginal;

    /**
     * @param bool $asOriginal
     */
    public function __construct(bool $asOriginal = false)
    {
        $this->asOriginal = $asOriginal;
    }

    /**
     * @inheritDoc
     */
    public function write($source, SpecificationInterface $specification, Compiler $compiler)
    {
        if (!$specification instanceof Filter\Between && !$specification instanceof Filter\ValueBetween) {
            return null;
        }

        $filters = $specification->getFilters($this->asOriginal);
        if (count($filters) > 1) {
            return $source->where(static function () use ($compiler, $source, $filters): void {
                $compiler->compile($source, ...$filters);
            });
        }

        if ($specification instanceof Filter\Between) {
            return $source->where(
                $specification->getExpression(),
                'BETWEEN',
                ...$specification->getValue()
            );
        }

        return $source->where(
            (string)$specification->getValue(),
            'BETWEEN',
            ...$specification->getExpression()
        );
    }
}
