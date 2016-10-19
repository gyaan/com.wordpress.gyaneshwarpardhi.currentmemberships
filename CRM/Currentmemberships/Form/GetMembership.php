<?php

require_once 'CRM/Core/Form.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Currentmemberships_Form_GetMembership extends CRM_Core_Form
{
    /**
     * create the form elements
     */
    public function buildQuickForm()
    {
        // add form elements
        $this->add('datepicker', 'start_from_date', 'Start from date', FALSE);
        $this->add('datepicker', 'start_to_date', 'Start to date', FALSE);
        $this->addButtons(array(array('type' => 'submit', 'name' => ts('Submit'), 'isDefault' => TRUE,)));

        // export form elements
        $this->assign('elementNames', $this->getRenderableElementNames());
        $this->assign('membership', $this->getMembership());
        parent::buildQuickForm();
    }

    /**
     * function to process the form element
     */
    public function postProcess()
    {
        //get the form values
        $values = $this->exportValues();
        $params = array();

        //if there is the date filter
        if (!empty($values['start_from_date']) && !empty($values['start_to_date'])) {
            CRM_Core_Session::setStatus(ts('You picked start date from "%1 to %2"', array(
                1 => $values['start_from_date'],
                2 => $values['start_to_date']
            )));

            //create the where condtion
            $params = array('start_date' => array(">=" => $values['start_from_date']), 'start_date' => array("<=" => $values['start_to_date']));

            //get the from and to date diff
            $diff = strtotime($values['start_to_date']) - strtotime($values['start_from_date']);

            //if to date is greater then from date then display alert message
            if ($diff < 0) {
                CRM_Core_Session::setStatus(ts('Picked start date from should less then start date to.:' . $diff));
                $params = array(); //get all the result
            }
        }

        $this->assign('membership', $this->getMembership($params));
        parent::postProcess();
    }


    /**
     * Get the fields/elements defined in this form.
     *
     * @return array (string)
     */
    public function getRenderableElementNames()
    {
        // The _elements list includes some items which should not be
        // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
        // items don't have labels.  We'll identify renderable by filtering on
        // the 'label'.
        $elementNames = array();
        foreach ($this->_elements as $element) {
            /** @var HTML_QuickForm_Element $element */
            $label = $element->getLabel();
            if (!empty($label)) {
                $elementNames[] = $element->getName();
            }
        }
        return $elementNames;
    }


    /**
     * @param array $params : array of where condition
     * @return array of membership details
     */
    function getMembership($params = array())
    {
        try {
            $params['api.Contact.getsingle']= array('id' => "\$value.contact_id");
            $membershipDetails = civicrm_api3('Membership', 'get',  $params);
            foreach($membershipDetails['values'] as $key => $membership){ //just form the array index to access in the smarty
                $membership['api_Contact_getsingle'] = $membership['api.Contact.getsingle'];
                unset($membership['api.Contact.getsingle']);
                $membershipDetails['values'][$key]=$membership;
            }
            return $membershipDetails;

        } catch (CiviCRM_API3_Exception $e) {
            // handle error here
            $errorMessage = $e->getMessage();
            $errorCode = $e->getErrorCode();
            $errorData = $e->getExtraParams();
            return array('error' => $errorMessage, 'error_code' => $errorCode, 'error_data' => $errorData);
        }
        return array();
    }
}
