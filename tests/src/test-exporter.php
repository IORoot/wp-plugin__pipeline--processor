<?php

/**
 * Class exporterTest
 *
 * @package Andyp_universal_exporter
 */

/**
 * @testdox Testing the \ue\exporter class
 */
class exporterTest extends WP_UnitTestCase {

    /**
     * @before
     */
	public function setup()
    {
        parent::setUp();
    }

    /**
     * @before
     * 
     * setup with an instance of the class.
     */
	public function setup_methods()
    {
        $this->instance = new \ue\exporter;
    }





    

}
