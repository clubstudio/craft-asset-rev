<?php

namespace Club\AssetRev;

use Twig_Extension;
use Twig_SimpleFunction;

class AssetRevTwigExtension extends Twig_Extension
{
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'Club Asset Rev';
    }

    /**
     * Get Twig Functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('rev', [$this, 'getAssetFilename']),
        ];
    }

    /**
     * Get the filename of a asset.
     *
     * @param      $file
     * @param bool $strict      Throw an exception if the file does not exist in the manifest file.
     *
     * @return string
     */
    public function getAssetFilename($file)
    {
        return AssetRev::getInstance()->assetRev->getAssetFilename($file);
    }
}
