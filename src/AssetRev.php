<?php

namespace Club\AssetRev;

use Craft;
use craft\base\Plugin;

class AssetRev extends Plugin
{
    public function init()
    {
        parent::init();

        $this->setComponents([
            'assetRev' => \Club\AssetRev\services\AssetRev::class,
        ]);

        Craft::$app->view->twig->addExtension(new AssetRevTwigExtension);
    }

    protected function createSettingsModel()
    {
        return new \Club\AssetRev\models\Settings();
    }
}
