<?php

namespace club\assetrev\utilities\strategies;

use club\assetrev\utilities\Strategy;
use club\assetrev\exceptions\ContinueException;

class ManifestFileStrategy extends Strategy
{
    protected static $manifest;

    public function rev($filename)
    {
        $manifest = $this->getAbsolutePath($this->config['manifestPath']);

        if (!is_file($manifest)) {
            throw new ContinueException("Manifest file `$manifest` does not exist");
        }

        if (is_null(self::$manifest)) {
            self::$manifest = json_decode(file_get_contents($manifest), true);
        }

        if (!isset(self::$manifest[$filename])) {
            throw new ContinueException("File `{$filename}` not found in assets manifest");
        }

        return self::$manifest[$filename];
    }
}
