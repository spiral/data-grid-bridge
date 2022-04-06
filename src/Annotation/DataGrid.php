<?php

declare(strict_types=1);

namespace Spiral\DataGrid\Annotation;

use Doctrine\Common\Annotations\Annotation;
use Spiral\Attributes\NamedArgumentConstructor;

/**
 * @Annotation
 * @NamedArgumentConstructor
 * @Target({"METHOD"})
 * @Annotation\Attributes({
 *     @Annotation\Attribute("grid", required=true, type="string"),
 *     @Annotation\Attribute("view", type="string"),
 *     @Annotation\Attribute("defaults", type="array"),
 *     @Annotation\Attribute("options", type="array"),
 *     @Annotation\Attribute("factory", type="string")
 * })
 */
#[\Attribute(\Attribute::TARGET_METHOD), NamedArgumentConstructor]
class DataGrid
{
    /**
     * @psalm-param non-empty-string $grid Points to grid schema
     * @psalm-param non-empty-string|null $view Response options,
     * default to GridSchema->__invoke() if such method exists
     * @param array $defaults Response options, default to GridSchema->getDefaults() if such method exists
     * @param array $options Response options, default to GridSchema->getOptions() if such method exists
     * @psalm-param class-string|null $factory Custom user GridFactory
     */
    public function __construct(
        public readonly string $grid,
        public readonly ?string $view = null,
        public readonly array $defaults = [],
        public readonly array $options = [],
        public readonly ?string $factory = null
    ) {
    }
}
