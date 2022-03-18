<?php

use club\assetrev\models\Settings;
use club\assetrev\exceptions\ContinueException;
use club\assetrev\utilities\strategies\QueryStringStrategy;

class QueryStringStrategyTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function it_throws_a_continue_exception_if_the_asset_file_cannot_be_found(): void
    {
        $this->expectException(ContinueException::class);

        $assetPath = stream_resolve_include_path('tests/files/asset.css');
        $assetsPath = str_replace('tests/files/asset.css', '', $assetPath);

        (new QueryStringStrategy(new Settings(), $assetsPath))->rev('css/asset.css');
    }

    /**
     * @test
     */
    public function it_appends_filemtime_as_a_query_string(): void
    {
        $asset = 'tests/files/asset.css';
        $assetPath = stream_resolve_include_path($asset);
        $assetsPath = str_replace($asset, '', $assetPath);

        $this->assertEquals(
            $asset . '?' . filemtime($assetPath),
            (new QueryStringStrategy(new Settings(), $assetsPath))->rev('tests/files/asset.css')
        );
    }

    /**
     * @test
     */
    public function it_finds_asset_files_when_the_asset_base_path_is_relative(): void
    {
        $asset = 'tests/files/nested/nested-asset.css';
        $assetPath = stream_resolve_include_path($asset);
        $assetsPath = str_replace($asset, '', $assetPath);

        $this->assertEquals(
            'nested-asset.css?' . filemtime($assetPath),
            (new QueryStringStrategy(new Settings(['assetsBasePath' => './tests/files/nested']), $assetsPath))->rev('nested-asset.css')
        );
    }

    /**
     * @test
     */
    public function it_finds_asset_files_when_the_asset_base_path_is_absolute(): void
    {
        $asset = 'tests/files/nested/nested-asset.css';
        $assetPath = stream_resolve_include_path($asset);
        $assetsPath = str_replace($asset, '', $assetPath);

        $this->assertEquals(
            $asset . '?' . filemtime($assetPath),
            (new QueryStringStrategy(
                new Settings(['assetsBasePath' => $assetsPath])
            ))->rev($asset)
        );
    }
}
