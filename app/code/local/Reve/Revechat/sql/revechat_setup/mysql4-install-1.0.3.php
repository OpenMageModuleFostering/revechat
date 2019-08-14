<?php
$installer = $this;
$installer->startSetup();

$installer->run("
   CREATE TABLE IF NOT EXISTS {$this->getTable('revechat')} (
      `revechat_id` int(11) NOT NULL auto_increment,
      `revechat_aid` varchar(100) NULL,
      PRIMARY KEY  (`revechat_id`)
   ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

   INSERT INTO {$this->getTable('revechat')} 
(`revechat_id`, `revechat_aid`) VALUES
(1, '');
");

$installer->endSetup();
