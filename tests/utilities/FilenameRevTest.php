<?php

use club\assetrev\models\Settings;
use club\assetrev\utilities\FilenameRev;

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
