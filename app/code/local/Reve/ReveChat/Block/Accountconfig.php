<?php
   define('REVECHAT_BASE_URL', "https://www.revechat.com/");
   define('REVECHAT_LOGIN_URL', REVECHAT_BASE_URL."plugins/login");
   define('REVECHAT_SIGNUP_URL', REVECHAT_BASE_URL."plugins/createTrialAccount");
   define('REVECHAT_GETACCOUNTDETAILS_URL', REVECHAT_BASE_URL."plugins/getAccountDetails");
class Reve_ReveChat_Block_Accountconfig extends Mage_Core_Block_Template
{

   private $revechat_model;
   protected function _toHtml()
   {
      $this->revechat_model = Mage::getModel('revechat/revechat')->load(1);
      $revechat_options = $this->revechat_model->_data;

      $error = array();

      

      if($this->getRequest()->getParam('revechat_remove')){
          $this->revechat_model->setRevechatAid("");
          $this->revechat_model->setRevechatTrackingId("");
      }else
      {
        if(($this->getRequest()->getParam('revechat_aid')!="") && $this->getRequest()->getParam('revechat_trackingid')!=""){
         $revechat_aid = $this->getRequest()->getParam('revechat_aid');
         $revechat_tracking_id = $this->getRequest()->getParam('revechat_trackingid');


         $this->revechat_model->setRevechatAid($revechat_aid);
         $this->revechat_model->setRevechatTrackingId($revechat_tracking_id);
      }
      }

      $this->revechat_model->save();

      $html = '<form action="'.$this->curpageurl().'" method="get" id="revechat-admin-settings-form">';
      if(($this->revechat_model->getRevechatAid() == '' || $this->revechat_model->getRevechatAid() == '0') || ($this->revechat_model->getRevechatTrackingId() == '' || $this->revechat_model->getRevechatTrackingId() == '0')) {
         $html .= '<div>
                    <div class="form-item form-type-item" id="edit-choose-form">
                        <h3>Already have a REVE Chat account?</h3>
                        <ul id="revechat_choose_form">
                            <li>
                                <input type="radio" checked="checked" id="has_revechat_account" name="revechat_choose_form">
                                <label for="has_revechat_account">Yes, I already have a REVE Chat account</label>
                            </li>
                            <li>
                                <input type="radio" id="new_revechat_account" name="revechat_choose_form">
                                <label for="new_revechat_account">No, I want to create one</label>
                            </li>
                        </ul>
                    </div><!--edit-choose-form-->
                    <div id="revechat_already_have">
                        <h3>Account Details</h3>
                        <fieldset id="edit-general" class="form-wrapper">
                            <div class="form-item form-type-item" id="edit-ajax-message">
                                <p class="ajax_message"></p>
                            </div>
                            <div class="form-item form-type-textfield form-item-revechat-account-email">
                                <label for="edit-revechat-account-email">REVE Chat Login Email </label>
                                <input type="text" class="form-text" maxlength="128" size="60" value="" name="revechat_account_email" id="edit-revechat-account-email">
                            </div>
                            <input type="hidden" value="0" name="revechat_aid">
                            <input type="hidden" value="0" name="revechat_trackingid">
                        </fieldset>
                    </div><!-- revechat_already_have -->

                    <div id="revechat_new_account">
                        <h3>Create a new REVE Chat account</h3>
                        <fieldset id="edit-new-revechat-account" class="form-wrapper">
                            <div class="fieldset-wrapper">
                                <p class="ajax_message"></p>

                                <div class="form-item form-type-textfield form-item-name">
                                    <label for="edit-name">Name </label>
                                    <input type="text" class="form-text" maxlength="128" size="60" value="" name="name" id="edit-name">
                                </div>
                                <div class="form-item form-type-textfield form-item-email">
                                    <label for="edit-email">Email </label>
                                    <input type="text" class="form-text" maxlength="128" size="60" value="" name="email" id="edit-email">
                                </div>
                                <div class="form-item form-type-textfield form-item-Phone">
                                    <label for="edit-phone">Phone </label>
                                    <input type="text" class="form-text" maxlength="128" size="60" value="" name="Phone" id="edit-phone">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div id="edit-actions" class="form-actions form-wrapper">
                        <input type="submit" class="form-submit" value="Save" name="op" id="edit-submit">
                    </div>
                </div>';
      }
      else{
         $html .= '<div>
                    <div class="messages revechat_success">REVE Chat
                        is installed.</div>
                    <input type="hidden" name="revechat_aid">
                    <input type="hidden" name="revechat_trackingid">
                    <div id="edit-actions" class="form-actions form-wrapper">
                        <input type="submit" class="form-submit" value="Remove" name="revechat_remove" id="edit-submit">

                    </div>
                </div>';
      }
      $html .= '</form>';
      
      return $html;
   }

   public function _prepareLayout()
   {
      $head = $this->getLayout()->getBlock('head');
      $head->addJs('revechat/jquery-1.4.2.min.js');
      $head->addJs('revechat/revechat.js');
      $head->addCss('revechat/revechat.css');
      return parent::_prepareLayout();
   }
   private function curPageURL() {
      $pageURL = 'http';
      if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
      $pageURL .= "://";
      if ($_SERVER["SERVER_PORT"] != "80") {
         $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
      } else {
         $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
      }

      $pageURL = preg_replace("/\?.*$/", "", $pageURL);

      return $pageURL;
   }

}
