<?php
class Reve_ReveChat_AdminController extends Mage_Adminhtml_Controller_Action
{
	public function accountconfigAction()
	{
		$this->loadLayout()
			->_addContent($this->getLayout()->createBlock('revechat/accountconfig'))
			->renderLayout();
	}
	public function indexAction()
    {
       accountconfigAction();
    }
}
