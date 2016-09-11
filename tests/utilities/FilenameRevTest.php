<?php

use AssetRev\Utilities\FilenameRev;

class FilenameRevTest extends PHPUnit_Framework_TestCase
{
    protected $class;

    /**
     * @test
     */
    public function it_is_instantiable_with_an_manifest_path()
    {
        $manifestPath = '/resources/assets/assets.json';

        $class = new FilenameRev($manifestPath);

        $this->assertAttributeEquals($manifestPath, 'manifestPath', $class);
    }

    /**
     * @test
     */
    public function it_is_instantiable_with_an_assets_path()
    {
        $assetsPath = '/asset/base/path';

        $class = new FilenameRev(null, $assetsPath);

        $this->assertAttributeEquals($assetsPath, 'assetsBasePath', $class);
    }

    /**
     * @test
     */
    public function it_is_instantiable_with_an_asset_url_prefix()
    {
        $assetPrefix = '/asset/base/path';

        $class = new FilenameRev(null, null, $assetPrefix);

        $this->assertAttributeEquals($assetPrefix, 'assetUrlPrefix', $class);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_the_file_to_rev_doesnt_exist()
    {
        $this->expectException(InvalidArgumentException::class);

        (new FilenameRev)->rev('missing-file.css');
    }

    /**
     * @test
     */
    public function it_appends_filemtime_as_a_query_string_if_there_isnt_a_manifest_file()
    {
        $asset = 'files/asset.css';
        $assetPath = stream_resolve_include_path($asset);
        $assetsPath = str_replace($asset, '', $assetPath);

        $revver = new FilenameRev;
        $revver->setBasePath($assetsPath);

        $this->assertEquals(
            $asset . '?' . filemtime($assetPath),
            $revver->rev($asset)
        );
    }

    /**
     * @test
     */
    public function it_prepends_the_asset_prefix_to_the_outputted_file_name()
    {
        $asset = 'files/asset.css';
        $assetPath = stream_resolve_include_path($asset);
        $assetsPath = str_replace($asset, '', $assetPath);

        $revver = new FilenameRev(null, null, 'asset/base/path/');
        $revver->setBasePath($assetsPath);

        $this->assertEquals(
            'asset/base/path/files/asset.css?' . filemtime($assetPath),
            $revver->rev($asset)
        );
    }

    /**
     * @test
     */
    public function it_doesnt_prepend_the_asset_prefix_when_the_prefix_is_absolute()
    {
        $asset = 'files/asset.css';
        $assetPath = stream_resolve_include_path($asset);
        $assetsPath = str_replace($asset, '', $assetPath);

        $revver = new FilenameRev(null, null, $assetsPath);
        $revver->setBasePath($assetsPath);

        $this->assertEquals(
            $assetsPath . $asset . '?' . filemtime($assetPath),
            $revver->rev($asset)
        );
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_the_file_does_not_exist_in_the_manifest()
    {
        $this->expectException(InvalidArgumentException::class);

        $asset = 'files/asset.css';
        $assetPath = stream_resolve_include_path($asset);
        $assetsPath = str_replace($asset, '', $assetPath);

        $manifestPath = stream_resolve_include_path('files/manifest.json');

        $revver = new FilenameRev('files/manifest.json');
        $revver->setBasePath($assetsPath);
        $revver->rev($asset);
    }

    /**
     * @test
     */
    public function it_replaces_the_file_name_with_the_revved_version_in_the_manifest_file()
    {
        $assetPath = stream_resolve_include_path('files/asset.css');
        $assetsPath = str_replace('files/asset.css', '', $assetPath);

        $revver = new FilenameRev('files/manifest.json');
        $revver->setBasePath($assetsPath);

        $this->assertEquals(
            'css/asset.a9961d38.css',
            $revver->rev('css/asset.css')
        );
    }

    /**
     * @test
     */
    public function it_can_rev_using_a_manifest_file_with_an_absolute_path()
    {
        $assetPath = stream_resolve_include_path('files/asset.css');
        $assetsPath = str_replace('files/asset.css', '', $assetPath);

        $revver = new FilenameRev($assetsPath . 'files/manifest.json');
        $revver->setBasePath($assetsPath);

        $this->assertEquals(
            'css/asset.a9961d38.css',
            $revver->rev('css/asset.css')
        );
    }
}
