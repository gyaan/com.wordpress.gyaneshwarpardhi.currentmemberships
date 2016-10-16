<?php

require_once 'CRM/Core/Page.php';

class CRM_Currentmemberships_Page_Membership extends CRM_Core_Page {
  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(ts('Membership'));
    $membership = $this->membership_get_example();

    // Example: Assign a variable for use in a template
    $this->assign('currentTime', date('Y-m-d H:i:s'));
    $this->assign('membership',$membership);
    parent::run();
  }


  function membership_get_example(){
    $params = array(
//        'membership_type_id' => 21,
    );
    try{
      $result = civicrm_api3('membership', 'get', $params);
    }
    catch (CiviCRM_API3_Exception $e) {
      // handle error here
      $errorMessage = $e->getMessage();
      $errorCode = $e->getErrorCode();
      $errorData = $e->getExtraParams();
      return array('error' => $errorMessage, 'error_code' => $errorCode, 'error_data' => $errorData);
    }
    return $result;
  }
}
