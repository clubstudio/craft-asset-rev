<?php
namespace Craft;

class AssetRevPlugin extends BasePlugin
{
	/**
	 * @return string
	 */
	public function getName()
	{
		return 'Asset Rev';
	}

	/**
	 * Returns the plugin’s version number.
	 *
	 * @return string The plugin’s version number.
	 */
	public function getVersion()
	{
		return '3.0.0';
	}

	/**
	 * Returns the plugin developer’s name.
	 *
	 * @return string The plugin developer’s name.
	 */
	public function getDeveloper()
	{
		return 'Club Studio Ltd';
	}

	/**
	 * Returns the plugin developer’s URL.
	 *
	 * @return string The plugin developer’s URL.
	 */
	public function getDeveloperUrl()
	{
		return 'https://clubstudio.co.uk';
	}

	/**
	 * @return string
	 */
	public function getDocumentationUrl()
	{
		return 'https://github.com/clubstudioltd/craft-asset-rev';
	}

	/**
	 * Add Twig Extension
	 *
	 * @return AssetRevTwigExtension
	 * @throws \Exception
	 */
	public function addTwigExtension()
	{
		Craft::import('plugins.assetrev.twigextensions.AssetRevTwigExtension');

		return new AssetRevTwigExtension();
	}
}
