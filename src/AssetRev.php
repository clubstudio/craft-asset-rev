<?php

namespace club\assetrev;

use Craft;
use craft\base\Plugin;
use club\assetrev\models\Settings;
use club\assetrev\services\AssetRev as Service;

class AssetRev extends Plugin
{
    public function init(): void
    {
        parent::init();

        $this->setComponents([
            'assetRev' => Service::class,
        ]);

        Craft::$app->view->registerTwigExtension(new AssetRevTwigExtension);
    }

    protected function createSettingsModel(): \craft\base\Model
    {
        return new Settings();
    }
}
