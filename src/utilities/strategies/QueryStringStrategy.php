<?php

namespace club\assetrev\utilities\strategies;

use club\assetrev\utilities\Strategy;
use club\assetrev\exceptions\ContinueException;

class QueryStringStrategy extends Strategy
{
    public function rev($filename): string
    {
        $file = $this->prependAssetBasePath($filename);

        if (!file_exists($file)) {
            throw new ContinueException("Cannot append query string - the file `$file` does not exist");
        }

        $queryString = '?' . filemtime($file);

        return $filename . $queryString;
    }

    protected function prependAssetBasePath($file): string
    {
        if (!empty($this->config['assetsBasePath'])) {
            return $this->getAbsolutePath(
                $this->normalisePath($this->config['assetsBasePath']) . DIRECTORY_SEPARATOR . $file
            );
        }

        return $file;
    }
}
