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

class Default_NationalityController extends Zend_Controller_Action
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
		$nationalitymodel = new Default_Model_Nationality();	
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
				
		$dataTmp = $nationalitymodel->getGrid($sort, $by, $perPage, $pageNo, $searchData,$call,$dashboardcall);
					
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
		$objName = 'nationality';
		$nationalityform = new Default_Form_nationality();
		$nationalityform->removeElement("submit");
		$elements = $nationalityform->getElements();
		if(count($elements)>0)
		{
			foreach($elements as $key=>$element)
			{
				if(($key!="Cancel")&&($key!="Edit")&&($key!="Delete")&&($key!="Attachments")){
				$element->setAttrib("disabled", "disabled");
					}
        	}
        }
		$nationalitymodel = new Default_Model_Nationality();	
		try
		{
			if(is_numeric($id) && $id>0)
			{
				$data = $nationalitymodel->getNationalityDataByID($id);
				
				if(!empty($data))
				{
					$nationalityform->populate($data[0]);
					$this->view->controllername = $objName;
					$this->view->id = $id;
					$this->view->data = $data[0];
					$this->view->form = $nationalityform;
					$this->view->ermsg = '';
				}
				else
				{
					$this->view->ermsg = 'nodata';
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
		
		$nationalityform = new Default_Form_nationality();
		$nationalitymodel = new Default_Model_Nationality();
		try
		{
		    if($id)
			{
				if(is_numeric($id) && $id>0)
				{
					$data = $nationalitymodel->getNationalityDataByID($id);
					
					if(!empty($data))
					{
						$nationalityform->populate($data[0]);
						$nationalityform->submit->setLabel('Update');
						 $this->view->id = $id;
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
			}else
            {
			   $this->view->ermsg = '';
            }	
		}
		catch(Exception $e)
		{
			 $this->view->ermsg = 'nodata';
		}
		$this->view->form = $nationalityform;
		if($this->getRequest()->getPost()){
		    if($nationalityform->isValid($this->_request->getPost())){
			    $nationalitycode = $this->_request->getParam('nationalitycode');
				$description = $this->_request->getParam('description');
				$date = new Zend_Date();
				$actionflag = '';
				$tableid  = ''; 
				   $data = array('nationalitycode'=>trim($nationalitycode),
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
					$Id = $nationalitymodel->SaveorUpdateNationalityData($data, $where);
					if($Id == 'update')
					{
					   $tableid = $id;
					   $this->_helper->getHelper("FlashMessenger")->addMessage(array("success"=>"Nationality code updated successfully."));
					}   
					else
					{
                       $tableid = $Id; 	
                        $this->_helper->getHelper("FlashMessenger")->addMessage(array("success"=>"Nationality code  added successfully."));					   
					}   
					$menuID = NATIONALITY;
					$result = sapp_Global::logManager($menuID,$actionflag,$loginUserId,$tableid);
    			    $this->_redirect('nationality');		
			}else
			{
     			$messages = $nationalityform->getMessages();
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
			 $nationalitymodel = new Default_Model_Nationality();
			  $nationalitydata = $nationalitymodel->getNationalityDataByID($id);
			  $data = array('isactive'=>0,'modifieddate'=>gmdate("Y-m-d H:i:s"));
			  $where = array('id=?'=>$id);
			  $Id = $nationalitymodel->SaveorUpdateNationalityData($data, $where);
			    if($Id == 'update')
				{
				   $menuID = NATIONALITY;
				   $result = sapp_Global::logManager($menuID,$actionflag,$loginUserId,$id);
                   $configmail = sapp_Global::send_configuration_mail('Nationality',$nationalitydata[0]['nationalitycode']);				   
				   $messages['message'] = 'Nationality code deleted successfully.';
				   $messages['msgtype'] = 'success';
				}   
				else
				{
                   $messages['message'] = 'Nationality code cannot be deleted.';	
				   $messages['msgtype'] = 'error';
                } 				   
			}
			else
			{ 
			 $messages['message'] = 'Nationality code cannot be deleted.';
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
	
	public function addpopupAction()
	{
		Zend_Layout::getMvcInstance()->setLayoutPath(APPLICATION_PATH."/layouts/scripts/popup/");
		$auth = Zend_Auth::getInstance();
     	if($auth->hasIdentity()){
					$loginUserId = $auth->getStorage()->read()->id;
		}
		$id = $this->getRequest()->getParam('id');
		$controllername = 'nationality';
		
		$nationalityform = new Default_Form_nationality();
		$nationalitymodel = new Default_Model_Nationality();
		$nationalityform->setAction(BASE_URL.'nationality/addpopup');		
		
		
		if($this->getRequest()->getPost())
		{
		    if($nationalityform->isValid($this->_request->getPost()))
			{
			    $nationalitycode = $this->_request->getParam('nationalitycode');
				$description = $this->_request->getParam('description');
				$date = new Zend_Date();
				$actionflag = '';
				$tableid  = ''; 
				   $data = array('nationalitycode'=>trim($nationalitycode),
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
					$Id = $nationalitymodel->SaveorUpdateNationalityData($data, $where);
					$tableid = $Id;
					$menuID = NATIONALITY;
					$result = sapp_Global::logManager($menuID,$actionflag,$loginUserId,$tableid);
					
					$nationalitycodeData = $nationalitymodel->fetchAll('isactive = 1','nationalitycode')->toArray();
					$opt ='';   
					foreach($nationalitycodeData as $record)
					{
						$opt .= sapp_Global::selectOptionBuilder($record['id'], $record['nationalitycode']);
					}
					$this->view->nationalitycodeData = $opt;
    			    
					$this->view->eventact = 'added';
					$close = 'close';
					$this->view->popup=$close;
			}else
			{
     			$messages = $nationalityform->getMessages();
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
		$this->view->controllername = $controllername;
		$this->view->form = $nationalityform;
	}
	

}

