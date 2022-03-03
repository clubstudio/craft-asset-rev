<?php

namespace club\assetrev;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;


class AssetRevTwigExtension extends AbstractExtension
{
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName(): string
    {
        return 'Club Asset Rev';
    }

    /**
     * Get Twig Functions.
     *
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('rev', [$this, 'getAssetFilename']),
        ];
    }

    /**
     * Get the filename of an asset.
     *
     * @param string $file
     *
     * @return string
     */
    public function getAssetFilename(string $file): string
    {
        return AssetRev::getInstance()->assetRev->getAssetFilename($file);
    }
}
