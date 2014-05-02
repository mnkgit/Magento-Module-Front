<?php
class Excellence_Test_Block_Excellence extends Mage_Core_Block_Template
{
   // protected function _construct()
   // {
   //    parent::_construct();
   //    $this->setTemplate('test/test.phtml');
   // }
   public function methodinblock()
   {
        $retour=array();
        $collection = Mage::getModel('test/test')->getCollection()->setOrder('id','asc');
        $s=0;
        foreach($collection as $data)
        {
             $retour[$s]['id'] = $data->getData('id');
             $retour[$s]['title'] = $data->getData('title');
             $retour[$s]['desc'] = $data->getData('description');
             $retour[$s]['image'] = $data->getData('image');
          $s++;
        }
        return $retour;
   }
   public function formtest()
   {
      $id = (int) $this->getRequest()->getParam('id');
      $model = Mage::getModel('test/test');
      $model->load($id);
      $data = $model->getData();
      return $data;
   }

   function getCategoriesTreeView() {
    // Get category collection
    $categories = Mage::getModel('catalog/category')
        ->getCollection()
        ->addAttributeToSelect('name')
        ->addAttributeToSort('path', 'asc')
        ->addFieldToFilter('is_active', array('eq'=>'1'))
        ->load()
        ->toArray();

    // Arrange categories in required array
    $categoryList = array();
    foreach ($categories as $catId => $category) {
        if (isset($category['name'])) {
            $categoryList[] = array(
                'label' => $category['name'],
                'level'  =>$category['level'],
                'value' => $catId
            );
        }
    }
    return $categoryList;
}










   



  
}

?>