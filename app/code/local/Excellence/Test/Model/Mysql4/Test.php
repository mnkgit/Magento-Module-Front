<?php
class Excellence_Test_Model_Mysql4_Test extends Mage_Core_Model_Mysql4_Abstract
{
     public function _construct()
     {
         $this->_init('test/test', 'id');  // test/test is our entity and id.... to fetch table record
     }
}