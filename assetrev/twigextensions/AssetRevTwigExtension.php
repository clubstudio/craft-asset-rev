<?php
namespace Craft;

use Twig_Extension;
use Twig_Function_Method;

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
		return [
			'rev' => new Twig_Function_Method($this, 'getAssetFilename'),
		];
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
		return craft()->assetRev->getAssetFilename($file);
	}
}
