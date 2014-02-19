<?php

class Meanbee_Feedback_Test_Config_Base extends EcomDev_PHPUnit_Test_Case_Config {

    /**
     * @test
     */
    public function testClassAlias() {
        $this->assertBlockAlias('meanbee_feedback/test', 'Meanbee_Feedback_Block_Test');
        $this->assertHelperAlias('meanbee_feedback/test', 'Meanbee_Feedback_Helper_Test');
    }
}
