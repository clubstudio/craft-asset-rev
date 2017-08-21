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
        $config = [];
        $configKeys = ['pipeline', 'strategies', 'manifestPath', 'assetsBasePath', 'assetUrlPrefix'];
        foreach ($configKeys as $configKey) {
            $config[$configKey] = $this->parseEnvironmentString(
                craft()->config->get($configKey, 'assetrev')
            );
        }

        $revver = new FilenameRev($config);

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
