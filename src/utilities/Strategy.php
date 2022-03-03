<?php

namespace club\assetrev\utilities;

use craft\base\Model;

abstract class Strategy implements StrategyContract
{
    protected array|Model $config = [];
    protected ?string $basePath;

    public function __construct(Model $config, $basePath = null)
    {
        $this->config = $config;
        $this->basePath = $basePath;
    }

    protected function getAbsolutePath($path): string
    {
        if (str_starts_with($path, DIRECTORY_SEPARATOR) || empty($this->basePath)) {
            return $path;
        }

        return $this->basePath . DIRECTORY_SEPARATOR . $path;
    }

    protected function normalisePath($path): string
    {
        return rtrim($path, '/');
    }
}
