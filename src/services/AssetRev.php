<?php

namespace club\assetrev\services;

use Yii;
use craft\base\Model;
use craft\base\Component;
use club\assetrev\AssetRev as Plugin;
use club\assetrev\utilities\FilenameRev;

class AssetRev extends Component
{
    /**
     * Get the filename of a asset.
     *
     * @param $file
     * @throws InvalidArgumentException
     * @return string
     */
    public function getAssetFilename($file)
    {
        $settings = $this->parseAliases(Plugin::getInstance()->settings);

        $revver = new FilenameRev($settings);
        $revver->setBasePath(CRAFT_BASE_PATH);

        return $revver->rev($file);
    }

    /**
     * Replace Yii aliases.
     *
     * @param  Model  $settings
     * @return Model
     */
    protected function parseAliases(Model $settings)
    {
        $aliasables = ['manifestPath', 'assetsBasePath', 'assetUrlPrefix'];

        foreach ($aliasables as $aliasable) {
            $settings->{$aliasable} = Yii::getAlias($settings->{$aliasable});
        }

        return $settings;
    }

    /**
     * Build an asset's URL.
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
