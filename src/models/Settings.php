<?php

namespace club\assetrev\models;

use craft\base\Model;

class Settings extends Model
{
    public array $strategies = [];
    public string $pipeline = 'manifest|querystring|passthrough';
    public string $manifestPath = 'resources/assets/assets.json';
    public string $assetsBasePath = '';
    public ?string $assetUrlPrefix = null;

    /**
     * @inheritdoc
     */
    public function init(): void
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

    /**
     * @inheritdoc
     */
    public function rules(): array
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
