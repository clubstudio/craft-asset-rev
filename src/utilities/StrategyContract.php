<?php

namespace club\assetrev\utilities;

use craft\base\Model;

interface StrategyContract
{
    public function __construct(Model $config, $basePath = null);
    public function rev($file);
}
