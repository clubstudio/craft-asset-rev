<?php

namespace AssetRev\Utilities;

abstract class Strategy implements StrategyContract
{
    protected $config = [];
    protected $basePath;

    public function __construct(array $config = [], $basePath = null)
    {
        $this->config = $config;
        $this->basePath = $basePath;
    }

    protected function getAbsolutePath($path)
    {
        if (strpos($path, DIRECTORY_SEPARATOR) === 0) {
            return $path;
        }

        return $this->basePath . $path;
    }

    protected function normalisePath($path)
    {
        return rtrim($path, '/');
    }
}
