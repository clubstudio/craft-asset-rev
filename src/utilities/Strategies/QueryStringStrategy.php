<?php

namespace Club\AssetRev\utilities\Strategies;

use Club\AssetRev\utilities\Strategy;
use Club\AssetRev\exceptions\ContinueException;

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
