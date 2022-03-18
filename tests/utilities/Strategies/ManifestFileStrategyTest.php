<?php

use club\assetrev\models\Settings;
use club\assetrev\exceptions\ContinueException;
use club\assetrev\utilities\strategies\ManifestFileStrategy;

class ManifestFileStrategyTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function it_throws_a_continue_exception_if_the_manifest_file_does_not_exist(): void
    {
        $this->expectException(ContinueException::class);

        $assetPath = stream_resolve_include_path('files/asset.css');
        $assetsPath = str_replace('files/asset.css', '', $assetPath);

        $settingsModel = new Settings(['manifestPath' => 'files/missing.json']);

        (new ManifestFileStrategy($settingsModel, $assetsPath))->rev('css/asset.css');
    }

    /**
     * @test
     */
    public function it_throws_a_continue_exception_if_the_asset_is_not_found_in_the_manifest_file(): void
    {
        $this->expectException(ContinueException::class);

        $assetPath = stream_resolve_include_path('files/asset.css');
        $assetsPath = str_replace('files/asset.css', '', $assetPath);

        $settingsModel = new Settings(['manifestPath' => 'files/manifest.json']);

        (new ManifestFileStrategy($settingsModel, $assetsPath))->rev('css/missing.css');
    }

    /**
     * @test
     */
    public function it_finds_the_manifest_file_when_the_path_is_relative(): void
    {
        $assetPath = stream_resolve_include_path('files/asset.css');
        $assetsPath = str_replace('files/asset.css', '', $assetPath);
        $config = new Settings(['manifestPath' => './tests/files/manifest.json']);
        $revver = new ManifestFileStrategy($config, $assetsPath);

        $this->assertEquals('css/asset.a9961d38.css', $revver->rev('css/asset.css'));
    }

    /**
     * @test
     */
    public function it_finds_the_manifest_file_when_the_path_is_absolute(): void
    {
        $assetPath = stream_resolve_include_path('tests/files/asset.css');
        $assetsPath = str_replace('tests/files/asset.css', '', $assetPath);

        $config = new Settings(['manifestPath' => $assetsPath . '/tests/files/manifest.json']);

        $revver = new ManifestFileStrategy($config);

        $this->assertEquals('css/asset.a9961d38.css', $revver->rev('css/asset.css'));
    }

    /**
     * @test
     */
    public function it_replaces_the_file_name_with_the_revved_version_in_the_manifest_file(): void
    {
        $assetPath = stream_resolve_include_path('tests/files/asset.css');
        $assetsPath = str_replace('tests/files/asset.css', '', $assetPath);
        $config = new Settings(['manifestPath' => 'tests/files/manifest.json']);
        $revver = new ManifestFileStrategy($config, $assetsPath);

        $this->assertEquals(
            'css/asset.a9961d38.css',
            $revver->rev('css/asset.css')
        );
    }
}
