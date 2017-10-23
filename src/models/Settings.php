<?php

namespace club\assetrev\models;

use craft\base\Model;

class Settings extends Model
{
    public $strategies = [];
    public $pipeline = 'manifest|querystring|passthrough';
    public $manifestPath = 'resources/assets/assets.json';
    public $assetsBasePath = '';
    public $assetUrlPrefix = null;

    public function init()
    {
        parent::init();

        $this->strategies = [
            'manifest' => \club\assetrev\utilities\strategies\ManifestFileStrategy::class,
            'querystring' => \club\assetrev\utilities\strategies\QueryStringStrategy::class,
            'passthrough' => function ($filename, $config) {
                return $filename;
            },
        ];
    }

    public function rules()
    {
        return [
            ['strategies', 'required'],
            ['pipeline', 'required'],
            ['manifestPath', 'required'],
            ['assetsBasePath', 'required'],
            ['assetUrlPrefix', 'required'],
        ];
    }
}
