<?php
namespace Craft;

use Twig_Extension;
use Twig_Function_Method;
use InvalidArgumentException;

class AssetRevTwigExtension extends Twig_Extension
{
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
	 * Get the filename of a asset
	 *
	 * @param      $file
	 * @param null $manifestPath
	 *
	 * @return mixed
	 */
	public function getAssetFilename($file, $manifestPath = null)
	{
		$settings = craft()->plugins->getPlugin('assetRev')->getSettings();

		if (empty($settings['manifestPath']))
		{
			throw new InvalidArgumentException("Manifest path not set in plugin settings.");
		}

		$manifestPath = !is_null($manifestPath) ? $manifestPath : CRAFT_BASE_PATH.$settings['manifestPath'];

		// If the manifest file can't be found, we'll just return the original filename
		if (!$this->manifestExists($manifestPath))
		{
			return $file;
		}

		return $this->getAssetRevisionFilename($manifestPath, $file);
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
		return file_exists($manifest);
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
