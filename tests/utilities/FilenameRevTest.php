<?php

use Club\AssetRev\models\Settings;
use Club\AssetRev\utilities\FilenameRev;

class FilenameRevTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_is_instantiable_with_configuration()
    {
        $config = new Settings(['manifestPath' => 'bar']);
        $class = new FilenameRev($config);

        $this->assertAttributeEquals($config, 'config', $class);
    }
}
