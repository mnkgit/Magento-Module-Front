<?php

class Excellence_Test_Model_Test extends Mage_Core_Model_Abstract
{
     public function _construct()
     {
         parent::_construct();
         $this->_init('test/test');   //it oints resource file in our resource model described in etc/config file
     }
}