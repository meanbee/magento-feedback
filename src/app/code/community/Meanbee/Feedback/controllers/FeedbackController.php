<?php

class Meanbee_Feedback_FeedbackController extends Mage_Core_Controller_Front_Action {

    /** @var Meanbee_Feedback_Helper_Config $config */
    protected $config;

    public function _construct() {
        parent::_construct();

        $this->config = Mage::helper('meanbee_feedback/config');
    }

    public function submitAction() {
        $request = $this->getRequest();

        if (!$this->config->isEnabled() || !$request->isAjax() || !$request->isPost()) {
            $this->_forward('noRoute');
            return;
        }

        if ($feedback = $this->getFeedbackObject()) {
            if (!$this->sendFeedbackEmail($feedback)) {
                Mage::logException(new Exception('Failed to send customer feedback email.'));
            }
        } else {
            $order_number = $request->getParam('order_number');
            $message = ($order_number === null || $order_number === "") ? "Order number is missing." : sprintf('Order number "%s" does not exist.', $order_number);

            Mage::logException(new Exception(sprintf("Customer feedback not saved: %s", $message)));
        }

        $this->getResponse()->setBody(sprintf("<p>%s</p>", $this->__('Thank you for your feedback.')));
    }

    /**
     * Send the customer feedback to a recipient if one is defined in configuration.
     *
     * @param $feedback
     *
     * @return bool
     */
    protected function sendFeedbackEmail($feedback) {
        $to = $this->config->getEmailAddress();

        if ($to) {
            $template_id = $this->config->getEmailTemplate();
            $template = Mage::getModel('core/email_template');

            $parameters = array(
                'feedback' => $feedback
            );

            $template->sendTransactional(
                $template_id,
                'general',
                $to,
                '',
                $parameters
            );

            return $template->getSentSuccess();
        }

        return true;
    }

    /**
     * Return the customer feedback data from the current request as an object.
     *
     * @return Varien_Object
     */
    protected function getFeedbackObject() {
        $request = $this->getRequest();

        if ($order_number = $request->getParam('order')) {
            $order = Mage::getModel('sales/order')->loadByIncrementId($order_number);

            if ($order->getId()) {
                $feedback = new Varien_Object();

                $feedback->setData(array(
                    'customer_name' => $order->getCustomerName(),
                    'order_number'  => $order->getIncrementId(),
                    'order_total'   => Mage::helper('core')->formatPrice($order->getTotalDue(), true),
                    'rating'        => $request->getParam('rating'),
                    'comments'      => $request->getParam('comments')
                ));

                return $feedback;
            }
        }

        return null;
    }
}
