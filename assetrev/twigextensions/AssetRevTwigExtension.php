<?php
namespace Craft;

use Twig_Extension;
use Twig_Function_Method;
use InvalidArgumentException;

class AssetRevTwigExtension extends Twig_Extension
{
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
		return array(
			'rev' => new Twig_Function_Method($this, 'getAssetRevisionFilename'),
		);
	}

	/**
	 * Get the filename of a asset revision from the asset manifest
	 *
	 * @param      $file
	 * @param null $manifestPath
	 *
	 * @return mixed
	 */
	public function getAssetRevisionFilename($file, $manifestPath = null)
	{
		static $manifest = null;

		$manifestPath = !is_null($manifestPath) ? $manifestPath : CRAFT_BASE_PATH.'../resources/assets/assets.json';

		if (is_null($manifest))
		{
			$manifest = json_decode(file_get_contents($manifestPath), true);
		}

		if (!isset($manifest[$file]))
		{
			throw new InvalidArgumentException("File {$file} not found in assets manifest");
		}

		return $manifest[$file];
	}
}