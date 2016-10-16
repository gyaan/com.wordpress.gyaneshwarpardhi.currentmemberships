<?php

require_once 'CRM/Core/Form.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Currentmemberships_Form_GetMembership extends CRM_Core_Form {
  public function buildQuickForm() {

    // add form elements
    $this->add(
      'text', // field type
      'start_date', // field name
      'Start from date', // field label
       FALSE // is required
    );

    $this->add(
        'text',
        'end_date',
        'Start To Date',
         False
    );
    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    $this->assign('membership',$this->membership_get_example());
    parent::buildQuickForm();
  }

  public function postProcess() {
    $values = $this->exportValues();
    CRM_Core_Session::setStatus(ts('You picked start date from "%1 to %2"', array(
      1 => $values['start_date'],
      2 => $values['end_date']
    )));

    $params = array();

    if(!empty($values['start_date']) && !empty($values['end_date']))
    $params = array('start_date' => array(">="=>$values['start_date']), 'start_date' => array("<="=>$values['end_date']));

    $this->assign('membership',$this->membership_get_example($params));
    parent::postProcess();
  }


  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
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


  function membership_get_example($params=array())
  {
    try {
      $result = civicrm_api3('membership', 'get', $params);
    } catch (CiviCRM_API3_Exception $e) {
      // handle error here
      $errorMessage = $e->getMessage();
      $errorCode = $e->getErrorCode();
      $errorData = $e->getExtraParams();
      return array('error' => $errorMessage, 'error_code' => $errorCode, 'error_data' => $errorData);
    }
    return $result;
  }
}
