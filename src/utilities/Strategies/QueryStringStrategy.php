<?php

namespace Club\AssetRev\Utilities\Strategies;

use Club\AssetRev\Utilities\Strategy;
use Club\AssetRev\Exceptions\ContinueException;

class QueryStringStrategy extends Strategy
{
    public function rev($filename)
    {
        $file = $this->prependAssetBasePath($filename);

        if (!file_exists($file)) {
            throw new ContinueException("Cannot append query string - the file `$file` does not exist");
        }

        $queryString = '?' . filemtime($file);

        return $filename . $queryString;
    }

    protected function prependAssetBasePath($file)
    {
        if (!empty($this->config['assetsBasePath'])) {
            return $this->getAbsolutePath(
                $this->normalisePath($this->config['assetsBasePath']) . DIRECTORY_SEPARATOR . $file
            );
        }

        return $file;
    }
}
