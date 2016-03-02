<?php
namespace Craft;

use Twig_Extension;
use Twig_Function_Method;
use InvalidArgumentException;

class AssetRevTwigExtension extends Twig_Extension
{
	static protected $settings;
	static protected $manifest;

	/**
	 * Returns the name of the extension.
	 *
	 * @return string The extension name
	 */
	public function getName()
	{
		return 'Club Asset Rev';
	}

	/**
	 * Get Twig Functions
	 *
	 * @return array
	 */
	public function getFunctions()
	{
		return [
			'rev' => new Twig_Function_Method($this, 'getAssetFilename'),
		];
	}

	/**
	 * Builds an array of settings for the plugin
	 *
	 * @return array
	 */
	protected function settings()
	{
		if (is_null(self::$settings))
		{
			self::$settings = array(
				'manifestPath' => craft()->config->get('manifestPath', 'assetrev'),
				'assetsBasePath' => craft()->config->get('assetsBasePath', 'assetrev'),
			);
		}

		return self::$settings;
	}

	/**
	 * Get the filename of a asset
	 *
	 * @param $file
	 * @throws InvalidArgumentException
	 * @return string
	 */
	public function getAssetFilename($file)
	{
		$settings = $this->settings();
		$manifestPath = $settings['manifestPath'];

		if (empty($settings['manifestPath']))
		{
			throw new InvalidArgumentException("Manifest path `manifestPath` not set in plugin configuration.");
		}

		// Allow for a relative path
		if (strpos($manifestPath, DIRECTORY_SEPARATOR) !== 0) {
			$manifestPath = CRAFT_BASE_PATH.$manifestPath;
		}

		// If the manifest file can't be found, we'll just return the original filename
		if (!$this->manifestExists($manifestPath))
		{
			return $this->buildAssetUrl($settings['assetsBasePath'], $file);
		}

		return $this->buildAssetUrl($settings['assetsBasePath'], $this->getAssetRevisionFilename($manifestPath, $file));
	}

	/**
	 * Build an asset's URL
	 *
	 * @param  string $basePath Base path to assets as defined in the plugin settings
	 * @param  string $file     Asset filename
	 *
	 * @return string           Path to the asset - environment variables having been replaced with their values.
	 */
	protected function buildAssetUrl($basePath, $file)
	{
		return craft()->config->parseEnvironmentString($basePath) . $file;
	}

	/**
	 * Check if the requested manifest file exists
	 *
	 * @param $manifest
	 *
	 * @return bool
	 */
	protected function manifestExists($manifest)
	{
		return is_file($manifest);
	}

	/**
	 * Get the filename of an asset revision from the asset manifest
	 *
	 * @param $manifestPath
	 * @param $file
	 *
	 * @return mixed
	 */
	protected function getAssetRevisionFilename($manifestPath, $file)
	{
		if (is_null(self::$manifest))
		{
			self::$manifest = json_decode(file_get_contents($manifestPath), true);
		}

		if (!isset(self::$manifest[$file]))
		{
			throw new InvalidArgumentException("File {$file} not found in assets manifest");
		}

		return self::$manifest[$file];
	}
}
