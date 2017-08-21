<?php

namespace AssetRev\Utilities;

interface StrategyContract
{
    public function __construct(array $config = [], $basePath = null);
    public function rev($file);
}
