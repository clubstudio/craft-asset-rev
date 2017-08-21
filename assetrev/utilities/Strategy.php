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

    protected function getAbsolutePath($file)
    {
        if (strpos($file, DIRECTORY_SEPARATOR) === 0) {
            return $file;
        }

        return $this->basePath . $file;
    }

    protected function normalisePath($path)
    {
        return ltrim(rtrim($path, '/'), '/');
    }
}
