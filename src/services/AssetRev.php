<?php

namespace club\assetrev\services;

use Yii;
use craft\helpers\App;
use craft\base\Model;
use craft\base\Component;
use club\assetrev\AssetRev as Plugin;
use club\assetrev\utilities\FilenameRev;
use yii\base\InvalidArgumentException;

class AssetRev extends Component
{
    /**
     * Get the filename of an asset.
     *
     * @param $file
     * @throws InvalidArgumentException
     * @return string
     */
    public function getAssetFilename($file): string
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
    protected function parseAliases(Model $settings): Model
    {
        $aliasables = ['manifestPath', 'assetsBasePath', 'assetUrlPrefix'];

        foreach ($aliasables as $aliasable) {
            $settings->{$aliasable} = Yii::getAlias($settings->{$aliasable});
        }

        return $settings;
    }
}
