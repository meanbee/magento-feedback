<?php

class Meanbee_Feedback_FeedbackController extends Mage_Core_Controller_Front_Action {

    public function submitAction() {
        $this->getResponse()->setBody('Hello world!');
    }
}
