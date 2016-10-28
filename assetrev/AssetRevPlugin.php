<?php
namespace Craft;

class AssetRevPlugin extends BasePlugin
{
	public function init()
	{
		require_once __DIR__.'/vendor/autoload.php';
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'Asset Rev';
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return 'Cache bust you asset filenames';
	}

	/**
	 * Returns the plugin’s version number.
	 *
	 * @return string The plugin’s version number.
	 */
	public function getVersion()
	{
		return '4.0.1';
	}

	/**
	 * Returns the plugin’s release feed.
	 *
	 * @return JSON
	 */
	public function getReleaseFeedUrl()
	{
		return 'https://raw.githubusercontent.com/clubstudioltd/craft-asset-rev/master/releases.json';
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
