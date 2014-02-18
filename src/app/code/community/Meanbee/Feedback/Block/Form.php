<?php

class Meanbee_Feedback_Block_Form extends Mage_Core_Block_Template {

    /**
     * Return the action parameter value for the feedback form.
     *
     * @return string
     */
    protected function getFormAction() {
        return Mage::getUrl('meanbee_feedback/feedback/submit');
    }

    /**
     * Return the number of the last order.
     *
     * @return int
     */
    protected function getOrderNumber() {
        $order_number = $this->getData('order_number');

        if (!$order_number) {
            $order_id = Mage::getSingleton('checkout/session')->getLastOrderId();
            if ($order_id) {
                $order = Mage::getModel('sales/order')->load($order_id);
                if ($order->getId()) {
                    $order_number = $order->getIncrementId();
                    $this->setData('order_number', $order_number);
                }
            }
        }

        return $order_number;
    }
}
