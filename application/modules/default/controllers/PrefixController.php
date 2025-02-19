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

class Default_PrefixController extends Zend_Controller_Action
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
		$prefixmodel = new Default_Model_Prefix();
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

		$dataTmp = $prefixmodel->getGrid($sort, $by, $perPage, $pageNo, $searchData,$call,$dashboardcall);
			
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
		$objName = 'prefix';
		$prefixform = new Default_Form_prefix();
		$prefixform->removeElement("submit");
		$elements = $prefixform->getElements();
	
		if(count($elements)>0)
		{
			foreach($elements as $key=>$element)
			{
				if(($key!="Cancel")&&($key!="Edit")&&($key!="Delete")&&($key!="Attachments")){
					$element->setAttrib("disabled", "disabled");
				}
			}
		}
		$prefixmodel = new Default_Model_Prefix();
		try
		{
			if($id)
			{
				if(is_numeric($id) && $id>0)
				{
					$data = $prefixmodel->getsinglePrefixData($id);
                  
					if(!empty($data) && $data != "norows")
					{
						$prefixform->populate($data[0]);
						$this->view->form = $prefixform;
						$this->view->controllername = $objName;
						$this->view->data = $data;
						$this->view->id = $id;
						$this->view->ermsg = '';
					}
					else
					{
						$this->view->ermsg = 'nodata';
					}
				}else
				{
					$this->view->ermsg = 'nodata';
				}
			}else
			{
				$this->view->ermsg = 'nodata';
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

		$prefixform = new Default_Form_prefix();
		$prefixmodel = new Default_Model_Prefix();
		try
		{
			if($id)
			{
				if(is_numeric($id) && $id>0)
				{
					$data = $prefixmodel->getsinglePrefixData($id);
					
					if(!empty($data) && $data != "norows")
					{
						$prefixform->populate($data[0]);
						$prefixform->submit->setLabel('Update');
						$this->view->data = $data;
						$this->view->id = $id;
						$this->view->ermsg = '';
					}
					else
					{
						$this->view->ermsg = 'nodata';
					}
				}else
				{
					$this->view->ermsg = 'nodata';
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
		$this->view->form = $prefixform;
		if($this->getRequest()->getPost()){
			if($prefixform->isValid($this->_request->getPost())){
				$prefix = $this->_request->getParam('prefix');
				$description = $this->_request->getParam('description');
				$date = new Zend_Date();
				$actionflag = '';
				$tableid  = '';
				$data = array('prefix'=>trim($prefix),
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
				$Id = $prefixmodel->SaveorUpdatePrefixData($data, $where);
				if($Id == 'update')
				{
					$tableid = $id;
					$this->_helper->getHelper("FlashMessenger")->addMessage(array("success"=>"Prefix updated successfully."));
				}
				else
				{
					$tableid = $Id;
					$this->_helper->getHelper("FlashMessenger")->addMessage(array("success"=>"Prefix  added successfully."));
				}
				$menuID = PREFIX;
				$result = sapp_Global::logManager($menuID,$actionflag,$loginUserId,$tableid);
				$this->_redirect('prefix');
			}else
			{
				$messages = $prefixform->getMessages();
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

	public function saveupdateAction()
	{
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()){
			$loginUserId = $auth->getStorage()->read()->id;
		}
		$id = $this->_request->getParam('id');
		$gendercode = $this->_request->getParam('gendercode');
		$gendername = $this->_request->getParam('gendername');
		$description = $this->_request->getParam('description');
		$genderform = new Default_Form_gender();
		$gendermodel = new Default_Model_Gender();
		$messages = $genderform->getMessages();
		$actionflag = '';
		$tableid  = '';

		if($this->getRequest()->getPost()){
			if($genderform->isValid($this->_request->getPost())){
				$data = array('gendercode'=>trim($gendercode),
				           'gendername'=>trim($gendername),
						  'description'=>trim($description),
						  'modifiedby'=>$loginUserId,
						  'modifieddate'=>Zend_Registry::get('currentdate')
				);
				if($id!=''){
					$where = array('id=?'=>$id);
					$messages['message']='Gender updated successfully.';
					$actionflag = 2;

				}
				else
				{
					$data['createdby'] = $loginUserId;
					$data['createddate'] = Zend_Registry::get('currentdate');
					$data['isactive'] = 1;
					$where = '';
					$messages['message']='Gender added successfully.';
					$actionflag = 1;
				}
				$Id = $gendermodel->SaveorUpdateGenderData($data, $where);
				if($Id == 'update')
				$tableid = $id;
				else
				$tableid = $Id;
				$menuID = GENDER;
				$result = sapp_Global::logManager($menuID,$actionflag,$loginUserId,$tableid);
				$messages['result']='saved';
				$this->_helper->json($messages);
					
			}else
			{
				$messages = $genderform->getMessages();
				$messages['result']='error';
				$this->_helper->json($messages);
					
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
			$prefixmodel = new Default_Model_Prefix();
			$prefixdata = $prefixmodel->getsinglePrefixData($id);

			$data = array('isactive'=>0,'modifieddate'=>gmdate("Y-m-d H:i:s"));
			$where = array('id=?'=>$id);
			$Id = $prefixmodel->SaveorUpdatePrefixData($data, $where);
			if($Id == 'update')
			{
				$menuID = PREFIX;
				$result = sapp_Global::logManager($menuID,$actionflag,$loginUserId,$id);
				$configmail = sapp_Global::send_configuration_mail('Prefix',$prefixdata[0]['prefix']);
					
				$messages['message'] = 'Prefix deleted successfully.';
				$messages['msgtype'] = 'success';
			}
			else
			{
				$messages['message'] = 'Prefix cannot be deleted.';
				$messages['msgtype'] = 'error';
			}
		}
		else
		{
			$messages['message'] = 'Prefix cannot be deleted.';
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

		$msgarray = array();
		$controllername = 'prefix';
		$prefixform = new Default_Form_prefix();
		$prefixmodel = new Default_Model_Prefix();
		$prefixform->setAction(BASE_URL.'prefix/addpopup');
		if($this->getRequest()->getPost()){
			if($prefixform->isValid($this->_request->getPost())){
				$id = $this->_request->getParam('id');
				$prefix = $this->_request->getParam('prefix');
				$description = $this->_request->getParam('description');
				$date = new Zend_Date();
				$actionflag = '';
				$tableid  = '';
				$data = array('prefix'=>trim($prefix),
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

				$Id = $prefixmodel->SaveorUpdatePrefixData($data, $where);
				$tableid = $Id;
				$menuID = PREFIX;
				$result = sapp_Global::logManager($menuID,$actionflag,$loginUserId,$tableid);

				$prefixData = $prefixmodel->fetchAll('isactive = 1','prefix')->toArray();
				$opt ='';
				foreach($prefixData as $record){
					$opt .= sapp_Global::selectOptionBuilder($record['id'], $record['prefix']);
				}
				$this->view->prefixData = $opt;
					
				$this->view->eventact = 'added';
				$close = 'close';
				$this->view->popup=$close;
			}else
			{
				$messages = $prefixform->getMessages();
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
		$this->view->form = $prefixform;
		$this->view->ermsg = '';

	}



}

