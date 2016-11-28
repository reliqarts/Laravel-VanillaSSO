<?php

use ReliQArts\VanillaSSO\VanillaSSO;

class VanillaSSOTest extends \Orchestra\Testbench\TestCase
{
    /**
     * Test instance creation.
     */
    public function testCreate()
    {
        $vanillaSSO = new VanillaSSO();

        $this->assertNotNull($vanillaSSO);
        $this->assertTrue(method_exists($vanillaSSO, 'SignJsConnect'));
    }
}
