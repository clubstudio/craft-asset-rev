<img src="./src/icon.svg" width="64">

# CraftCMS Asset Rev / Cache Busting
[![tests](https://github.com/clubstudioltd/craft-asset-rev/actions/workflows/tests.yml/badge.svg)](https://github.com/clubstudioltd/craft-asset-rev/actions/workflows/tests.yml)
[![Latest Stable Version](https://poser.pugx.org/clubstudioltd/craft-asset-rev/v/stable)](https://packagist.org/packages/clubstudioltd/craft-asset-rev)
[![Total Downloads](https://poser.pugx.org/clubstudioltd/craft-asset-rev/downloads)](https://packagist.org/packages/clubstudioltd/craft-asset-rev)
[![Latest Unstable Version](https://poser.pugx.org/clubstudioltd/craft-asset-rev/v/unstable)](https://packagist.org/packages/clubstudioltd/craft-asset-rev)
[![License](https://poser.pugx.org/clubstudioltd/craft-asset-rev/license)](https://packagist.org/packages/clubstudioltd/craft-asset-rev)

**Looking for Craft 2 Support?** [Asset Rev for Craft 2](https://github.com/clubstudioltd/craft-asset-rev/tree/v5)

A Twig extension for CraftCMS that helps you cache-bust your assets using configurable strategies.

## Why?
In order to speed up the load time of your pages, you can set a far-future expires header on your images, stylesheets and scripts. However, when you update those assets you'll need to update their file names to force the browser to download the updated version.

Using a manifest file is the recommended approach - you can read up on why using query strings isn't ideal [here](http://www.stevesouders.com/blog/2008/08/23/revving-filenames-dont-use-querystring/).

## Strategies
This plugin allows you to configure multiple cache-busting strategies for your asset filenames.  The plugin comes with three strategies out of the box:

### Manifest File
`css/main.css` will be replaced with the corresponding hashed filename as defined within your assets manifest `.json` file.

If the contents of your manifest file are...

```json
{
    "css/main.css": "css/main.a9961d38.css",
    "js/main.js": "js/main.786087f5.js"
}
```

then `rev('css/main.css')` will expand to `css/main.a9961d38.css`.

**Please note:** This plugin __does not__ create manifest files; instead they should be generated during your build process using [Gulp Rev](https://github.com/sindresorhus/gulp-rev), [Laravel Mix](https://github.com/JeffreyWay/laravel-mix) or another comparable tool.

### Query String
Append a query string to your file, based on the time it was last modified. For example: `rev('css/main.css')` will expand to something like `css/main.css?1473534554`.

### Passthrough
Returns the original filename, without modification. This is useful if all other cache-busting strategies fail.

## Strategy Pipeline
Pipelines allow you to attempt multiple cache-busting strategies in sequence. If one strategy fails, the plugin can proceed to try and cache-bust the asset filename using the next strategy in the pipeline.

The default pipeline is `manifest|querystring|passthrough` and will:

1. Attempt to use the `ManifestFileStrategy`. If it can’t, because the manifest file doesn’t exist, it will throw a `ContinueException` that defers cache-busting to the next strategy in the pipeline…
2. Attempt to use the `QueryStringStrategy`. If it can’t, because it can’t find the asset file, it will throw another `ContinueException` that defers cache-busting to the final default strategy…
3. Returns the original filename using the closure-based pass-through strategy.

**Need to provide your own cache-busting logic?** Simply create your own implementation of the Strategy class or define a Closure in the configuration file.

## Installation
Install via the Plugin Store within your Craft 3 installation or using Composer: `composer require clubstudioltd/craft-asset-rev`

## Configuration
The plugin comes with a `config.php` file that defines some sensible defaults.

If you want to set your own values you should create a `assetrev.php` file in your Craft config directory. The contents of this file will get merged with the plugin defaults, so you only need to specify values for the settings you want to override.

### Strategies
`strategies` is where you define the strategies you'd like to try to rev your asset filename. You can provide the name of a class that implements `StrategyContact` or a custom closure. The defaults should cater to most requirements.

### Pipeline
`pipeline` allows you to set the order of the configured strategies you'd like to try when revving your asset file names. The default of: `manifest|querystring|passthrough` should be adequate for most use-cases.

### Manifest Path
`manifestPath` is where Craft should look for your manifest file. Non-absolute paths will be relative to the base path of your Craft installation (whatever `CRAFT_BASE_PATH` is set to).

### Assets Base Path
`assetsBasePath` is the the base path to your assets. Again, this is relative to your craft base directory, unless you supply an absolute directory path.

### Asset Url Prefix
`assetUrlPrefix` will be prepended to the output of `rev()`.

**Note:** You can use Yii aliases in your configuration values.

## An Example Config File
```php
<?php
return array(
    '*' => array(
        'strategies' => [
            'manifest' => \club\assetrev\utilities\strategies\ManifestFileStrategy::class,
            'querystring' => \club\assetrev\utilities\strategies\QueryStringStrategy::class,
            'passthrough' => function ($filename, $config) {
                return $filename;
            },
        ],
        'pipeline' => 'manifest|querystring|passthrough',
        'manifestPath' => 'resources/assets/assets.json',
        'assetsBasePath' => '../public/build/',
        'assetUrlPrefix' => '@web/assets',
    ),
);
```

## Usage
Once activated and configured you can use the `rev()` function in your templates.

```html
<link rel="stylesheet" href="{{ rev('css/main.css') }}">
```

## Custom Strategies
Need to provide your own cache-busting logic? Create your own Strategy class or simply use a Closure.

### Example Strategy Class
```php
<?php

namespace your\namespace;

use club\assetrev\utilities\Strategy;
use club\assetrev\exceptions\ContinueException;

class QueryStringStrategy extends Strategy
{
    public function rev($filename)
    {
        // add your logic to manipulate $filename here...
        return $filename;
    }
}
```

### Example Closure
Your method will have access to the asset filename and the plugin configuration array.

```php
function ($filename, $config) {
    // add your logic to manipulate $filename here...
    return $filename;
}
```
