<?php
class Reve_ReveChat_Model_Mysql4_ReveChat_Collection extends Varien_Data_Collection_Db
{
    protected $_revechatTable;
 
    public function __construct()
    {
        $resources = Mage::getSingleton('core/resource');
        parent::__construct($resources->getConnection('revechat_read'));
        $this->_revechatTable = $resources->getTableName('revechat/revechat');
 
        $this->_select->from(
        		array('revechat'=>$this->_revechatTable),
 		       	array('*')
        		);
        $this->setItemObjectClass(Mage::getConfig()->getModelClassName('revechat/revechat'));
    }
}