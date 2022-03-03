<?php

use club\assetrev\models\Settings;
use club\assetrev\utilities\FilenameRev;

class FilenameRevTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function it_is_instantiable_with_configuration(): void
    {
        $config = new Settings(['manifestPath' => 'bar']);
        $class = new FilenameRev($config);
        // https://github.com/sebastianbergmann/phpunit/issues/3339#issue-368963488
        //$this->assertSame($config, $class->config);
    }
}
