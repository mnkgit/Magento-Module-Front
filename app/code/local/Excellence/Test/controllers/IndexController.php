<?php

class Excellence_Test_IndexController extends Mage_Core_Controller_Front_Action
{
  public function indexAction()
  {
   	$this->loadLayout();
    // Mage::log($this->getLayout()->getUpdate()->getHandles(),null,'layout.log');
    // Mage::log($this->getLayout()->getUpdate()->asString(),null,'layout.log');
    $this->renderLayout();
  }
    
	public function saveAction() 
	{
		$id = (int) $this->getRequest()->getParam('id');
  	if($id != '')
		{
        //EDIT DATA
        $title = ''.$this->getRequest()->getPost('title');
        $description = ''.$this->getRequest()->getPost('description');
        $model = Mage::getModel('test/test')->load($id)->addData($data);
        try
        {

            //-------*-----------*-----------*------------
              $uploader = new Varien_File_Uploader('fileinputname');
              $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything
              $uploader->setAllowRenameFiles(false);
              $uploader->setFilesDispersion(false);
              $path = Mage::getBaseDir('media') . DS ;
              $uploader->save($path, $_FILES['fileinputname']['name']);
            //-------*-----------*-----------*------------

              $model->setData('title', $title);
              $model->setData('description', $description);
              $model->setData('image', $_FILES['fileinputname']['name']);
              $model->setId($id)->save();
     
              Mage::getSingleton('core/session')->addSuccess('Records saved successfully!');
              echo "Data updated successfully.";
        } catch (Exception $e){
              echo $e->getMessage();
        }
        $this->_redirect('test/index/new');
    }
		else
		{
			//SAVE NEW DATA
        $title = ''.$this->getRequest()->getPost('title');
        $description = ''.$this->getRequest()->getPost('description');
        if(isset($_FILES['fileinputname']['name']) and (file_exists($_FILES['fileinputname']['tmp_name']))) 
        {
          try{
            $uploader = new Varien_File_Uploader('fileinputname');
            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything
            $uploader->setAllowRenameFiles(false);
            $uploader->setFilesDispersion(false);
            $path = Mage::getBaseDir('media') . DS ;
            $uploader->save($path, $_FILES['fileinputname']['name']);
            $data['fileinputname'] = $_FILES['fileinputname']['name'];
          }catch(Exception $e) {
         
          }
        }
      // END OF IMAGE UPLOAD WORK
      $image = $data['fileinputname'];
      /*************************/
      if(isset($title)&&($title!='') && isset($description)&&($description!='') )
      {
          //on cree notre objet et on l'enregistre en base
          $contact = Mage::getModel('test/test');
          $contact->setData('title', $title);
          $contact->setData('description', $description);
          $contact->setData('image', $image);
          $contact->save();
          Mage::getSingleton('core/session')->addSuccess('Records saved successfully!');

          $url = Mage::getUrl('*/*');
          if ($_SERVER['HTTPS'] == 'on') {
                $url = str_replace('http:', 'https:', $url);
          }
      }
		}
     	$this->_redirect('test/index');
    }
    
    public function editAction()
    {
        $this->loadLayout();
        $this->renderLayout();
        $id = (int) $this->getRequest()->getParam('id');
        $data = Mage::getModel('test/test');
        $data->load($id);
        $records = $data->getData();
        return $retour;

    }
	  public function newAction()
    {	
     	  $this->loadLayout();
        $this->renderLayout();
    }
 	  public function deleteAction() {
        $id = (int) $this->getRequest()->getParam('id');
        $model = Mage::getModel('test/test');
        $model->setId($id)->delete();
        $url = Mage::getUrl('*/*');
        if ($_SERVER['HTTPS'] == 'on') {
          $url = str_replace('http:', 'https:', $url);
        }
        $message = $this->__('Record Deleted successfully!');
        Mage::getSingleton('core/session')->addNotice($message); 
        $this->_redirectReferer($url);
    }
     public function deleteImageAction() {

        $id = (int) $this->getRequest()->getParam('id');
        $model = Mage::getModel('test/test');
        //$model->setId($id)->delete();
        $model = Mage::getModel('test/test')->load($id)->addData($data);
        $model->setData('image','');
        $model->setId($id)->save();

        $url = Mage::getUrl('*/*');
        if ($_SERVER['HTTPS'] == 'on') {
          $url = str_replace('http:', 'https:', $url);
        }
        $message = $this->__('Image Deleted successfully!');
        Mage::getSingleton('core/session')->addNotice($message); 
        $this->_redirectReferer($url);
    }

}
?>
