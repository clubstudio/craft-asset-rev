<?php

namespace AssetRev\Utilities;

use InvalidArgumentException;

class FilenameRev
{
    protected $manifestPath;
    protected $assetsBasePath;
    protected $assetUrlPrefix;
    protected $basePath;

    static protected $manifest;

    public function __construct($manifestPath = null, $assetsBasePath = null, $assetUrlPrefix = null)
    {
        $this->manifestPath = $manifestPath;
        $this->assetsBasePath = $assetsBasePath;
        $this->assetUrlPrefix = $assetUrlPrefix;
    }

    public function normalisePath($path)
    {
        return ltrim(rtrim($path, '/'), '/');
    }

    public function setBasePath($path)
    {
        return $this->basePath = $path;
    }

    public function getAbsolutePath($file)
    {
        if (strpos($file, DIRECTORY_SEPARATOR) === 0) {
            return $file;
        }

        return $this->basePath . $file;
    }

    public function rev($file)
    {
        $manifest = $this->getAbsolutePath($this->manifestPath);

        $revvedFile = $this->manifestExists($manifest) ?
            $this->revUsingManifest($manifest, $file) :
            $this->appendQueryString($file);

        return $this->prependAssetPrefix($revvedFile);
    }

    protected function manifestExists($manifestPath)
    {
        return is_file($manifestPath);
    }

    protected function revUsingManifest($manifest, $file)
    {
        if (is_null(self::$manifest)) {
            self::$manifest = json_decode(file_get_contents($manifest), true);
        }

        if (!isset(self::$manifest[$file])) {
            throw new InvalidArgumentException("File `{$file}` not found in assets manifest");
        }

        return self::$manifest[$file];
    }

    protected function appendQueryString($filename)
    {
        $file = $this->prependAssetBasePath($filename);

        if (!file_exists($file)) {
            throw new InvalidArgumentException("Cannot append query string - the file `$file` does not exist.");
        }

        $queryString = '?' . filemtime($file);

        return $filename . $queryString;
    }

    protected function prependAssetBasePath($file)
    {
        if (!empty($this->assetsBasePath)) {
            return $this->getAbsolutePath(
                $this->normalisePath($this->assetsBasePath) . DIRECTORY_SEPARATOR . $file
            );
        }

        return $file;
    }

    protected function prependAssetPrefix($file)
    {
        if (!empty($this->assetUrlPrefix)) {
            return $this->assetUrlPrefix . $file;
        }

        return $file;
    }
}
