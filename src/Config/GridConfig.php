<?php

declare(strict_types=1);

namespace Spiral\DataGrid\Config;

use Spiral\Core\InjectableConfig;

/**
 * Configuration for data grid bridge writers.
 */
final class GridConfig extends InjectableConfig
{
    public const CONFIG = 'dataGrid';

    /** @var array */
    protected array $config = [
        'writers' => [],
    ];

    public function getWriters(): array
    {
        return $this->config['writers'];
    }
}
