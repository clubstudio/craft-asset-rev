<?php

use AssetRev\Utilities\FilenameRev;

class FilenameRevTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_is_instantiable_with_configuration()
    {
        $config = ['foo' => 'bar'];
        $class = new FilenameRev($config);

        $this->assertAttributeEquals($config, 'config', $class);
    }
}
