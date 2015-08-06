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
		return '2.0.1';
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

	/**
	 * Define plugin settings
	 *
	 * @return array
	 */
	protected function defineSettings()
	{
		return array(
			'manifestPath' => array(AttributeType::String, 'required' => true),
		);
	}

	/**
	 * Get settings html
	 *
	 * @return string
	 */
	public function getSettingsHtml()
	{
		return craft()->templates->render('assetrev/_settings', array(
			'settings' => $this->getSettings(),
			'basePath' => CRAFT_BASE_PATH,
		));
	}
}
