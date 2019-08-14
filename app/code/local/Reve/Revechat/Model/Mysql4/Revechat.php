<?php
class Reve_Revechat_Model_Mysql4_Revechat extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('revechat/revechat', 'revechat_id');
    }
}