<?php

use AssetRev\Exceptions\ContinueException;
use AssetRev\Utilities\Strategies\QueryStringStrategy;

class QueryStringStrategyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_throws_a_continue_exception_if_the_asset_file_cannot_be_found()
    {
        $this->expectException(ContinueException::class);

        $assetPath = stream_resolve_include_path('files/asset.css');
        $assetsPath = str_replace('files/asset.css', '', $assetPath);

        (new QueryStringStrategy([], $assetsPath))->rev('css/asset.css');
    }

    /**
     * @test
     */
    public function it_appends_filemtime_as_a_query_string()
    {
        $asset = 'files/asset.css';
        $assetPath = stream_resolve_include_path($asset);
        $assetsPath = str_replace($asset, '', $assetPath);

        $this->assertEquals(
            $asset . '?' . filemtime($assetPath),
            (new QueryStringStrategy([], $assetsPath))->rev('files/asset.css')
        );
    }

    /**
     * @test
     */
    public function it_finds_asset_files_when_the_asset_base_path_is_relative()
    {
        $asset = 'files/nested/nested-asset.css';
        $assetPath = stream_resolve_include_path($asset);
        $assetsPath = str_replace($asset, '', $assetPath);

        $this->assertEquals(
            'nested-asset.css?' . filemtime($assetPath),
            (new QueryStringStrategy(['assetsBasePath' => './files/nested'], $assetsPath))->rev('nested-asset.css')
        );
    }

    /**
     * @test
     */
    public function it_finds_asset_files_when_the_asset_base_path_is_absolute()
    {
        $asset = 'files/nested/nested-asset.css';
        $assetPath = stream_resolve_include_path($asset);
        $assetsPath = str_replace($asset, '', $assetPath);

        $this->assertEquals(
            $asset . '?' . filemtime($assetPath),
            (new QueryStringStrategy(['assetsBasePath' => $assetsPath]))->rev($asset)
        );
    }
}
