<?php

class Meanbee_Feedback_Helper_Config extends Mage_Core_Helper_Abstract {

    const XML_PATH_ENABLED         = 'meanbee_feedback/general/enabled';
    const XML_PATH_EMAIL_ADDRESS   = 'meanbee_feedback/email/address';
    const XML_PATH_EMAIL_TEMPLATE  = 'meanbee_feedback/email/template';

    public function isEnabled() {
        return (Mage::getStoreConfig(self::XML_PATH_ENABLED)) ? true : false;
    }

    public function getEmailAddress() {
        return Mage::getStoreConfig(self::XML_PATH_EMAIL_ADDRESS);
    }

    public function getEmailTemplate() {
        return Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE);
    }
}
