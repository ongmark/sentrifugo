<?php
/********************************************************************************* 
 *  This file is part of Sentrifugo.
 *  Copyright (C) 2015 Sapplica
 *   
 *  Sentrifugo is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Sentrifugo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Sentrifugo.  If not, see <https://www.gnu.org/licenses/>.
 *
 *  Sentrifugo Support <support@sentrifugo.com>
 ********************************************************************************/

class Default_NationalitycontextcodeController extends Zend_Controller_Action
{

    private $options;
	public function preDispatch()
	{
		 
		
	}
	
    public function init()
    {
        $this->_options= $this->getInvokeArg('bootstrap')->getOptions();
		
    }

    public function indexAction()
    {
		$nationalitycontextcodemodel = new Default_Model_Nationalitycontextcode();	
        $call = $this->_getParam('call');
		if($call == 'ajaxcall')
				$this->_helper->layout->disableLayout();
		
		$view = Zend_Layout::getMvcInstance()->getView();		
		$objname = $this->_getParam('objname');
		$refresh = $this->_getParam('refresh');
		$dashboardcall = $this->_getParam('dashboardcall');
		
		$data = array();
		$searchQuery = '';
		$searchArray = array();
		$tablecontent='';
		
		if($refresh == 'refresh')
		{
		    if($dashboardcall == 'Yes')
				$perPage = DASHBOARD_PERPAGE;
			else	
				$perPage = PERPAGE;
			$sort = 'DESC';$by = 'modifieddate';$pageNo = 1;$searchData = '';$searchQuery = '';$searchArray='';
		}
		else 
		{
			$sort = ($this->_getParam('sort') !='')? $this->_getParam('sort'):'DESC';
			$by = ($this->_getParam('by')!='')? $this->_getParam('by'):'modifieddate';
			if($dashboardcall == 'Yes')
				$perPage = $this->_getParam('per_page',DASHBOARD_PERPAGE);
			else 
			    $perPage = $this->_getParam('per_page',PERPAGE);
			$pageNo = $this->_getParam('page', 1);
			/** search from grid - START **/
			$searchData = $this->_getParam('searchData');	
			$searchData = rtrim($searchData,',');
			/** search from grid - END **/
		}
				
		$dataTmp = $nationalitycontextcodemodel->getGrid($sort, $by, $perPage, $pageNo, $searchData,$call,$dashboardcall);     				
			
		array_push($data,$dataTmp);
		$this->view->dataArray = $data;
		$this->view->call = $call ;
		$this->view->messages = $this->_helper->flashMessenger->getMessages();
    }

    public function viewAction()
	{	
		$id = $this->getRequest()->getParam('id');
		$callval = $this->getRequest()->getParam('call');
		if($callval == 'ajaxcall')
			$this->_helper->layout->disableLayout();
		$objName = 'nationalitycontextcode';
		$nationalitycontextcodeform = new Default_Form_nationalitycontextcode();
		$nationalitycontextcodeform->removeElement("submit");
		$elements = $nationalitycontextcodeform->getElements();
		if(count($elements)>0)
		{
			foreach($elements as $key=>$element)
			{
				if(($key!="Cancel")&&($key!="Edit")&&($key!="Delete")&&($key!="Attachments")){
				$element->setAttrib("disabled", "disabled");
					}
        	}
        }
		$nationalitycontextcodemodel = new Default_Model_Nationalitycontextcode();	
		try
		{
			if(is_numeric($id) && $id>0)
			{
				$data = $nationalitycontextcodemodel->getNationalityContextCodeDataByID($id);
			  
				
				if(!empty($data))
				{
					$nationalitycontextcodeform->populate($data[0]);
					$this->view->controllername = $objName;
					$this->view->id = $id;
					$this->view->data = $data[0];
					$this->view->form = $nationalitycontextcodeform;
					 $this->view->ermsg = '';
				}
				else
				{
					 $this->view->ermsg = 'norecord';
				}
			}
			else
			{
				 $this->view->ermsg = 'norecord';
			}
		}
		catch(Exception $e)
		{
			 $this->view->ermsg = 'nodata';
		}
		
	}
	
	
	public function editAction()
	{	
	    $auth = Zend_Auth::getInstance();
     	if($auth->hasIdentity()){
					$loginUserId = $auth->getStorage()->read()->id;
		}
		$id = $this->getRequest()->getParam('id');
		$callval = $this->getRequest()->getParam('call');
		if($callval == 'ajaxcall')
			$this->_helper->layout->disableLayout();
		
		$nationalitycontextcodeform = new Default_Form_nationalitycontextcode();
		$nationalitycontextcodemodel = new Default_Model_Nationalitycontextcode();
		try
		{
			if($id)
			{
				if(is_numeric($id) && $id>0)
				{
					$data = $nationalitycontextcodemodel->getNationalityContextCodeDataByID($id);
				
					
					if(!empty($data))
					{
						$nationalitycontextcodeform->populate($data[0]);
						$nationalitycontextcodeform->submit->setLabel('Update');
						$this->view->form = $nationalitycontextcodeform;
						  $this->view->ermsg = '';
						  $this->view->id = $id;
					}
					else
					{
						  $this->view->ermsg = 'norecord';
					}
					
				}
				else
				{
					$this->view->ermsg = 'norecord';
				}
			}else
            {
			   $this->view->ermsg = '';
            }	
		}
		catch(Exception $e)
		{
			  $this->view->ermsg = 'nodata';
		}
		$this->view->form = $nationalitycontextcodeform;
		if($this->getRequest()->getPost()){
		    if($nationalitycontextcodeform->isValid($this->_request->getPost())){
			    $nationalitycontextcode = $this->_request->getParam('nationalitycontextcode');
				$description = $this->_request->getParam('description');
				$date = new Zend_Date();
				$actionflag = '';
				$tableid  = ''; 
				   $data = array('nationalitycontextcode'=>trim($nationalitycontextcode),
				   			 'description'=>trim($description),
						  'modifiedby'=>$loginUserId,
						  'modifieddate'=>gmdate("Y-m-d H:i:s")
						);
					if($id!=''){
						$where = array('id=?'=>$id);  
						$actionflag = 2;
					}
					else
					{
					    $data['createdby'] = $loginUserId;
						$data['createddate'] = gmdate("Y-m-d H:i:s");
						$data['isactive'] = 1;
						$where = '';
						$actionflag = 1;
					}
					$Id = $nationalitycontextcodemodel->SaveorUpdateNationalityContextCodeData($data, $where);
					if($Id == 'update')
					{
					   $tableid = $id;
					   $this->_helper->getHelper("FlashMessenger")->addMessage(array("success"=>"Nationality context code updated successfully."));
					}   
					else
					{
                       $tableid = $Id; 	
                        $this->_helper->getHelper("FlashMessenger")->addMessage(array("success"=>"Nationality context code  added successfully."));					   
					}   
					$menuID = NATIONALITYCONTEXTCODE;
					$result = sapp_Global::logManager($menuID,$actionflag,$loginUserId,$tableid);
    			    $this->_redirect('nationalitycontextcode');		
			}else
			{
     			$messages = $nationalitycontextcodeform->getMessages();
				foreach ($messages as $key => $val)
					{
						foreach($val as $key2 => $val2)
						 {
							$msgarray[$key] = $val2;
                                                        break;
						 }
					}
				$this->view->msgarray = $msgarray;
			
			}
		}
	}
	

	
	public function deleteAction()
	{
	     $auth = Zend_Auth::getInstance();
     		if($auth->hasIdentity()){
					$loginUserId = $auth->getStorage()->read()->id;
				}
		 $id = $this->_request->getParam('objid');
		 $deleteflag= $this->_request->getParam('deleteflag');
		 $messages['message'] = '';
		 $messages['msgtype'] = '';
		 $actionflag = 3;
		    if($id)
			{
	    	  $nationalitycontextcodemodel = new Default_Model_Nationalitycontextcode();
			  $nationalitycontextdata = $nationalitycontextcodemodel->getNationalityContextCodeDataByID($id);
			  $data = array('isactive'=>0,'modifieddate'=>gmdate("Y-m-d H:i:s"));
			  $where = array('id=?'=>$id);
			  $Id = $nationalitycontextcodemodel->SaveorUpdateNationalityContextCodeData($data, $where);
			    if($Id == 'update')
				{
				   $menuID = NATIONALITYCONTEXTCODE;
				   $result = sapp_Global::logManager($menuID,$actionflag,$loginUserId,$id);
                   $configmail = sapp_Global::send_configuration_mail('Nationality Context Code',$nationalitycontextdata[0]['nationalitycontextcode']); 				   
				   $messages['message'] = 'Nationality context code deleted successfully.';
				   $messages['msgtype'] = 'success';
				}   
				else
				{
                   $messages['message'] = 'Nationality context code cannot be deleted.';	
                   $messages['msgtype'] = 'error';
                }				   
			}
			else
			{ 
			 $messages['message'] = 'Nationality context code cannot be deleted.';
			 $messages['msgtype'] = 'error';
			}
			if($deleteflag==1)
			{
				if(	$messages['msgtype'] == 'error')
				{
					$this->_helper->getHelper("FlashMessenger")->addMessage(array("error"=>$messages['message'],"msgtype"=>$messages['msgtype'] ,'deleteflag'=>$deleteflag));
				}
				if(	$messages['msgtype'] == 'success')
				{
					$this->_helper->getHelper("FlashMessenger")->addMessage(array("success"=>$messages['message'],"msgtype"=>$messages['msgtype'],'deleteflag'=>$deleteflag));
				}
					
			}
			$this->_helper->json($messages);
		
	}
	
	

}

