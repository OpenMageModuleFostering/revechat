<?php
class Reve_ReveChat_Model_Mysql4_ReveChat extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('revechat/revechat', 'revechat_id');
    }
}