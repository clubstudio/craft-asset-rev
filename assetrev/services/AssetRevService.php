<?php
namespace Craft;

use InvalidArgumentException;
use AssetRev\Utilities\FilenameRev;

class AssetRevService extends BaseApplicationComponent
{
    /**
     * Get the filename of a asset
     *
     * @param $file
     * @throws InvalidArgumentException
     * @return string
     */
    public function getAssetFilename($file)
    {
        $revver = new FilenameRev(
            $this->parseEnvironmentString(craft()->config->get('manifestPath', 'assetrev')),
            $this->parseEnvironmentString(craft()->config->get('assetsBasePath', 'assetrev')),
            $this->parseEnvironmentString(craft()->config->get('assetUrlPrefix', 'assetrev'))
        );

        $revver->setBasePath(CRAFT_BASE_PATH);

        return $revver->rev($file);
    }

    /**
     * Build an asset's URL
     *
     * @param  string $basePath Base path to assets as defined in the plugin settings
     * @param  string $file     Asset filename
     *
     * @return string           Path to the asset - environment variables having been replaced with their values.
     */
    protected function parseEnvironmentString($string)
    {
        return craft()->config->parseEnvironmentString($string);
    }
}
