<?php
/*********************************************************************************
 *  This file is part of Sentrifugo.
 *  Copyright (C) 2014 Sapplica
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

/**
 * Login_Model_Users
 *
 * @author Enrico Zimuel (enrico@zimuel.it)
 */
class Services_Model_Oncalls extends Zend_Db_Table_Abstract
{
	protected $_name = 'main_oncallrequest';
	protected $_primary = 'id';

	public function getOncalldata($page_no,$per_page,$userid,$statusflag)
    {
	   $result = array();
	  if(isset($userid) && $userid != '')
	  {
	    $db = Zend_Db_Table::getDefaultAdapter();
        $query_cnt = "select count(*) as count from main_oncallrequest l
					  left join main_employeeoncalltypes e on e.id=l.oncalltypeid
					  where (l.user_id=".$userid." and l.oncallstatus=".$statusflag." and l.isactive=1)";
        $result_cnt = $db->query($query_cnt)->fetch();
        $total_cnt = $result_cnt['count'];

		$offset = ($per_page*$page_no) - $per_page;
        $limit_str = " limit ".$per_page." offset ".$offset;
        $page_cnt = ceil($total_cnt/$per_page);

		$query = "select l.id,l.user_id,l.appliedoncallscount,l.from_date,l.to_date,e.oncalltype,l.oncallstatus from main_oncallrequest l
				  left join main_employeeoncalltypes e on e.id=l.oncalltypeid where (l.user_id=".$userid." and l.oncallstatus=".$statusflag." and l.isactive=1) ".$limit_str;
        $result = $db->query($query);
        $total_data = $result->fetchAll();

		$role_query = "select u.emprole,r.rolename,r.group_id from main_users u
				      inner join main_roles r on u.emprole = r.id and r.isactive=1 where (u.id=".$userid." and u.isactive=1)";
        $role_result = $db->query($role_query);
        $role_data = $role_result->fetch();
		//echo"<pre>";print_r($role_data);exit;

		$data = array('rows' => $total_data,'page_cnt' => $page_cnt,'role' => $role_data);


	  }else
	  {
	     $data = array('status'=>'0','message'=>'User Id cannot be empty.','result' => $result);
	  }
	  //echo "<pre>";print_r($data);exit;
	  return $data;
    }

	public function getEmployeeOncalldata($page_no,$per_page,$userid,$statusflag)
    {
	   $result = array();
	  if(isset($userid) && $userid != '')
	  {
	    $db = Zend_Db_Table::getDefaultAdapter();
        $query_cnt = "select count(*) as count from main_oncallrequest l
					  left join main_employeeoncalltypes e on e.id=l.oncalltypeid
					  LEFT JOIN `main_users` AS `u` ON u.id=l.user_id
					  where (l.rep_mang_id=".$userid." and l.oncallstatus=".$statusflag." and l.isactive=1 and u.isactive=1)";
        $result_cnt = $db->query($query_cnt)->fetch();
        $total_cnt = $result_cnt['count'];

		$offset = ($per_page*$page_no) - $per_page;
        $limit_str = " limit ".$per_page." offset ".$offset;
        $page_cnt = ceil($total_cnt/$per_page);

		$query = "select l.id,l.user_id,u.userfullname, e.oncalltype, if(l.oncallday = 1,'Full Day','Half Day') AS oncallday,
				  DATE_FORMAT(l.from_date,'".DATEFORMAT_MYSQL."') as from_date,DATE_FORMAT(l.to_date,'".DATEFORMAT_MYSQL."') as to_date,
				  l.oncallstatus,l.reason,DATE_FORMAT(l.createddate,'".DATEFORMAT_MYSQL."') as applieddate,
				  l.appliedoncallscount
				  from main_oncallrequest l
				  left join main_employeeoncalltypes e on e.id=l.oncalltypeid
				  LEFT JOIN `main_users` AS `u` ON u.id=l.user_id
				  where (l.rep_mang_id=".$userid." and l.oncallstatus=".$statusflag." and l.isactive=1 and u.isactive=1) ".$limit_str;
        $result = $db->query($query);
        $total_data = $result->fetchAll();

		$data = array('rows' => $total_data,'page_cnt' => $page_cnt);


	  }else
	  {
	     $data = array('status'=>'0','message'=>'User Id cannot be empty.','result' => $result);
	  }
	  //echo "<pre>";print_r($data);exit;
	  return $data;
    }

	public function getIndividulOncalldata($userid,$recordid)
	{
		$result = array();
	    if($userid != '' && $recordid !='')
	    {
	    $db = Zend_Db_Table::getDefaultAdapter();

		$query = "select l.id,l.user_id,u.userfullname, e.oncalltype, if(l.oncallday = 1,'Full Day','Half Day') AS oncallday,
				  DATE_FORMAT(l.from_date,'".DATEFORMAT_MYSQL."') as from_date,DATE_FORMAT(l.to_date,'".DATEFORMAT_MYSQL."') as to_date,
				  l.oncallstatus,l.reason,DATE_FORMAT(l.createddate,'".DATEFORMAT_MYSQL."') as applieddate,
				  l.appliedoncallscount
				  from main_oncallrequest l
				  left join main_employeeoncalltypes e on e.id=l.oncalltypeid
				  LEFT JOIN `main_users` AS `u` ON u.id=l.user_id
				  where (l.id=".$recordid." and l.user_id =".$userid." and l.isactive=1 and u.isactive=1) ";
        $result = $db->query($query);
        $total_data = $result->fetchAll();

		$data = array('rows' => $total_data);


	  }else
	  {
	     $data = array('status'=>'0','message'=>'User Id cannot be empty.','result' => $result);
	  }
	  //echo "<pre>";print_r($data);exit;
	  return $data;
	}

	public function getIndividulEmpOncalldata($userid,$recordid,$employeeid)
	{
		$result = array();
	    if($userid != '' && $recordid !='' && $employeeid !='')
	    {
	    $db = Zend_Db_Table::getDefaultAdapter();

		$query = "select l.id,l.user_id,u.userfullname, e.oncalltype, if(l.oncallday = 1,'Full Day','Half Day') AS oncallday,
				  DATE_FORMAT(l.from_date,'".DATEFORMAT_MYSQL."') as from_date,DATE_FORMAT(l.to_date,'".DATEFORMAT_MYSQL."') as to_date,
				  l.oncallstatus,l.reason,DATE_FORMAT(l.createddate,'".DATEFORMAT_MYSQL."') as applieddate,
				  l.appliedoncallscount
				  from main_oncallrequest l
				  left join main_employeeoncalltypes e on e.id=l.oncalltypeid
				  LEFT JOIN `main_users` AS `u` ON u.id=l.user_id
				  where (l.rep_mang_id=".$userid." and l.id=".$recordid." and l.user_id =".$employeeid." and l.isactive=1 and u.isactive=1) ";
        $result = $db->query($query);
        $total_data = $result->fetchAll();

		$data = array('rows' => $total_data);


	  }else
	  {
	     $data = array('status'=>'0','message'=>'User Id cannot be empty.','result' => $result);
	  }
	  //echo "<pre>";print_r($data);exit;
	  return $data;
	}

	public function approveEmpOncalldata($userid,$recordid,$employeeid,$actionstatus)
	{
		$result = array();
		$userfullname = '';
		$useremail = '';
		$businessunitid = '';
		$from_date = '';
		$to_date = '';
		$reason = '';
		$appliedoncallscount = '';
		$text = '';
	    if($userid != '' && $recordid !='' && $employeeid !='')
	    {
	    $db = Zend_Db_Table::getDefaultAdapter();
        $user_query = "SELECT u.userfullname,u.emailaddress,e.businessunit_id FROM main_users AS u
		               left join main_employees e on e.user_id=u.id
		               WHERE (u.isactive = 1 AND u.id=".$employeeid.")";
        $user_result = $db->query($user_query)->fetch();
		if(!empty($user_result))
		{
		   $userfullname = $user_result['userfullname'];
		   $useremail = $user_result['emailaddress'];
		   $businessunitid = $user_result['businessunit_id'];
		}


		$oncall_query = "SELECT l.reason,l.appliedoncallscount,DATE_FORMAT(l.from_date,'".DATEFORMAT_MYSQL."') as from_date,
		                DATE_FORMAT(l.to_date,'".DATEFORMAT_MYSQL."') as to_date FROM main_oncallrequest AS l
						where (l.rep_mang_id=".$userid." and l.id=".$recordid." and l.user_id =".$employeeid." and l.isactive=1)";
        $oncall_result = $db->query($oncall_query)->fetch();
		if(!empty($oncall_result))
		{
		   $from_date = $oncall_result['from_date'];
		   $to_date = $oncall_result['to_date'];
		   if($to_date == '' || $to_date == NULL)
		   $to_date = $from_date;
		   $reason = $oncall_result['reason'];
		   $appliedoncallscount = $oncall_result['appliedoncallscount'];
		}
		$date = gmdate("Y-m-d H:i:s");

		//echo "<pre>";print_r($oncall_result);exit;
		if($actionstatus == 2)
		{
		    $text = 'approved';
		    $db->query("update main_employeeoncalls  set used_oncalls = used_oncalls+".$appliedoncallscount." where user_id = ".$employeeid." AND alloted_year = year(now()) AND isactive = 1 ");
			$db->query("update main_oncallrequest  set oncallstatus = ".$actionstatus.",modifiedby = ".$userid.",
			            modifieddate = '".$date."' where (rep_mang_id=".$userid." and id=".$recordid." and user_id =".$employeeid." and isactive=1 )");
		}else if($actionstatus == 3)
		{

		   $text = 'rejected';
		   $db->query("update main_oncallrequest  set oncallstatus = ".$actionstatus.",modifiedby = ".$userid.",
            			modifieddate = '".$date."' where (rep_mang_id=".$userid." and id=".$recordid." and user_id =".$employeeid." and isactive=1)");
		}

		if($userfullname != ''&& $useremail != '' && $from_date != '' && $reason != '' && $appliedoncallscount !='')
		{

				/* Mail to Employee */
				$options['subject'] = 'On Call Request';
				$options['header'] = 'On Call Request';
				$options['fromEmail'] = DONOTREPLYEMAIL;
				$options['fromName'] = DONOTREPLYNAME;
				$options['toEmail'] = $useremail;
				//$options['cc'] = $hremail;
				$options['toName'] = $userfullname;
				if($text == 'approved')
				$options['message'] = '<div>The below oncall(s) has been approved.</div>';
				else
				$options['message'] = '<div>The below oncall(s) has been rejected.</div>';
				$options['message'] .= '<div>
								<div>Name : '.$userfullname.'</div>
								<div> No. of oncalls applied : '.$appliedoncallscount.'</div>
								<div>From : '.$from_date.'</div>
								<div>To : '.$to_date.'.</div>
								<div> Reason : '.$reason.'</div>
								</div>';
				$result = sapp_Global::_sendEmail($options);
				/* End */

				/* Mail to HR */
				if (defined('LV_HR_'.$businessunitid) && $businessunitid !='')
				{

				$options['subject'] = 'On Call Request';
				$options['header'] = 'On Call Request';
				$options['fromEmail'] = DONOTREPLYEMAIL;
				$options['fromName'] = DONOTREPLYNAME;
				$options['toEmail'] = constant('LV_HR_'.$businessunitid);
				//$options['cc'] = $hremail;
				$options['toName'] = 'On call management';
				if($text == 'approved')
				$options['message'] = '<div>The below on call(s) has been approved.</div>';
				else
				$options['message'] = '<div>The below on call(s) has been rejected.</div>';
				$options['message'] .= '<div>
								<div>Name : '.$userfullname.'</div>
								<div> No. of oncalls applied : '.$appliedoncallscount.'</div>
								<div>From : '.$from_date.'</div>
								<div>To : '.$to_date.'.</div>
								<div> Reason : '.$reason.'</div>
								</div>';
				$result = sapp_Global::_sendEmail($options);
				}
				/*END */
		}

		$data = array('status'=>'1','message'=>'On call request '.$text.' successfully.','result' => 'success');


	  }else
	  {
	     $data = array('status'=>'0','message'=>'User Id cannot be empty.','result' => $result);
	  }
	  //echo "<pre>";print_r($data);exit;
	  return $data;
	}


	public function getempdetails($userid)
    {
	   $result = array();
	   $repmanager_result = array();


	  if(isset($userid) && $userid != '')
	  {
	    $db = Zend_Db_Table::getDefaultAdapter();

        $emp_query = "SELECT e.date_of_joining,e.reporting_manager,e.businessunit_id,e.department_id FROM main_employees AS e WHERE (e.isactive = 1 AND e.user_id=".$userid.")";
        $emp_result = $db->query($emp_query)->fetch();

		$available_oncalls_query = "SELECT `el`.`emp_oncall_limit` AS `oncalllimit`, el.emp_oncall_limit - el.used_oncalls AS `remainingoncalls` FROM `main_employeeoncalls` AS `el` WHERE (el.user_id=".$userid." AND el.alloted_year = now() AND el.isactive = 1)";
        $available_oncalls_result = $db->query($available_oncalls_query)->fetch();

		$oncalltype_query = "SELECT `l`.`id`, `l`.`oncalltype`, `l`.`numberofdays` from `main_employeeoncalltypes` AS `l` WHERE (l.isactive = 1)";
        $oncalltype_result = $db->query($oncalltype_query)->fetch();


		if($emp_result['reporting_manager'] !='')
		{
		   $repmanager_query = "SELECT u.id,u.userfullname,u.emailaddress FROM main_users AS u WHERE (u.isactive = 1 AND u.id=".$emp_result['reporting_manager'].")";
           $repmanager_result = $db->query($repmanager_query)->fetch();
		}

		if($emp_result['department_id'] !='')
		{
		   $weekdetails_query = "SELECT  `l`.`is_halfday` FROM `main_oncallmanagement` AS `l`
								WHERE (l.department_id = ".$emp_result['department_id']." AND l.isactive = 1) ";
           $weekdetails_result = $db->query($weekdetails_query)->fetch();
		}


		$data = array('empdetails' => $emp_result,'repmanagerdetails' => $repmanager_result,'availableoncalls' =>$available_oncalls_result,'oncalltypes' => $oncalltype_result,'ishalfday' =>$weekdetails_result);


	  }else
	  {
	     $data = array('status'=>'0','message'=>'User Id cannot be empty.','result' => $result);
	  }
	  //echo "<pre>";print_r($data);exit;
	  return $data;
    }


	public function saveoncallrequest($userid,$reason,$oncalltypeid='',$oncallday='',$fromdate='',$todate='',$appliedoncallsdaycount)
    {

	   $result = array();
	   $messagearray = array();
	   $oncalldayArr = array(1,2);
	   $errorflag = "true";
	   $oncalltypecount = '';
	   $oncalltypetext = '';
	   $days = '';
	   $appliedoncallscount = '';


	  if(isset($userid) && $userid != '' && isset($reason) && $reason != '' && isset($oncalltypeid) && $oncalltypeid != '' && isset($oncallday) && $oncallday != '')
	  {
	    $db = Zend_Db_Table::getDefaultAdapter();
        $user_query = "SELECT u.userfullname,u.emailaddress FROM main_users AS u WHERE (u.isactive = 1 AND u.id=".$userid.")";
        $user_result = $db->query($user_query)->fetch();
		if(!empty($user_result))
		{
		   $userfullname = $user_result['userfullname'];
		   $useremail = $user_result['emailaddress'];
		}else
		{
			$errorflag = 'false';
		}

	    $oncalldetails = $this->getoncalldetails($userid);
		//echo "<pre>";print_r($oncalldetails);exit;
		if(!empty($oncalldetails['repmanagerdetails']) && !empty($oncalldetails['availableoncalls']) && !empty($oncalldetails['oncalltypes']) && !empty($oncalldetails['weekdetails']))
		{
		        $reportingmanagerid = $oncalldetails['repmanagerdetails']['id'];
		        $reportingmanageremail = $oncalldetails['repmanagerdetails']['emailaddress'];
				$reportingmanagername = $oncalldetails['repmanagerdetails']['userfullname'];
				$availableoncalls = $oncalldetails['availableoncalls']['remainingoncalls'];
				$businessunitid = $oncalldetails['empdetails']['businessunit_id'];
				$dateofjoining = $oncalldetails['empdetails']['date_of_joining'];
		        /*
				   START- On Call Type Validation
				   Server side validation for oncalltype count based on user selection.
				   This is to validate or negate if user manipulates the data in the browser or firebug.
				*/
				  if($oncalltypeid !='')
				  {
					   $oncalltypeArr = $this->getoncalltypedata($oncalltypeid);
					   //echo "<pre>";print_r($oncalltypeArr);exit;
					   if(!empty($oncalltypeArr))
					   {
							 $oncalltypecount = $oncalltypeArr['numberofdays'];
							 $oncalltypetext = $oncalltypeArr['oncalltype'];
					   }
					   else
					   {
						 $messagearray['oncall_type_id'] = 'Wrong inputs given.';
						 $errorflag = 'false';
					   }

				  }else
				  {
					  $messagearray['oncalltypeid'] = 'On call types are not configured yet.';
					  $errorflag = 'false';
				  }


				/*
				   END- On Call Type Validation
				*/

				/*
				   START- Oncall Day Validation
				   Server side validation for halfday and full day based on user selection.
				   This is to validate or negate if user manipulates the data in the browser or firebug.
				*/

				if($oncallday !='')
				{
				   if (!in_array($oncallday, $oncalldayArr))
					{
					   $messagearray['oncall_day'] = 'Wrong inputs given.';
					   $errorflag = 'false';
					}
				}else
				{
					$messagearray['oncall_day'] = 'Please select on call day.';
					$errorflag = 'false';
				}

				/*
				   END- Oncall Day Validation
				*/


				 /*
				   START- Day calculation and validations.
				   I. Calculation of days based on start date and end data.
				   II. Also checking whether Applied no of days is less than oncalltype configuration.
				   III. Also If oncallday is selected as full day then making todata as manadatory and
						if oncall day is selected as half day then no mandatory validation for todate.
				*/

				$from_date = sapp_Global::change_date($fromdate,'database');
				$to_date = sapp_Global::change_date($todate,'database');
				//echo "<pre>";print_r($oncalldetails);exit;
				if($from_date != '' && $to_date !='' && $oncalltypecount !='')
				{
					//$days = $this->calcBusinessDays($fromdate_obj,$todate_obj,$constantday);
					$days = $this->calculatebusinessdaysoncall($from_date,$to_date,$userid);
					if(is_numeric($days) && $oncalltypecount >= $days)
					{
							//$errorflag = 'true';
					}
					else
					{
					  if(!is_numeric($days))
						{
							//$messagearray['to_date'] = 'From date should be less than Todate.';
							$messagearray['to_date'] = 'To date should be greater than from date.';
							$errorflag = 'false';
						}
					  else
						{
						   $messagearray['to_date'] = $oncalltypetext." permits maximum of ".$oncalltypecount." on call days per request.";
						   $errorflag = 'false';
						}
					}

				}else
				{
				    if($oncallday == 1)
				    {
					   if($from_date == '')
					   {
						 $messagearray['from_date'] = "Please select date.";
						 $errorflag = 'false';
					   }
					   if($to_date == '')
					   {
						 $messagearray['to_date'] = "Please select date.";
						 $errorflag = 'false';
					   }
                    }else if($oncallday == 2)
					{
					   if($from_date == '')
					   {
						 $messagearray['from_date'] = "Please select date.";
						 $errorflag = 'false';
					   }
					}else
					{
						if($from_date == '')
					   {
						 $messagearray['from_date'] = "Please select date.";
						 $errorflag = 'false';
					   }
					   if($to_date == '')
					   {
						 $messagearray['to_date'] = "Please select date.";
						 $errorflag = 'false';
					   }
					}
				}
				/*
					END- Day calculation and validations.
				*/


				/*
				START- Validating Half day requests based on Oncall management options
				Validation for half day oncalls.
				If halfday oncall is configure in oncall management options then only half day oncall can be applied.
				*/
				$ishalf_day = $oncalldetails['weekdetails']['is_halfday'];
				if($ishalf_day == 2)
				{
				   if($oncallday == 2)
				   {
					$errorflag = 'false';
					$messagearray['oncall_day'] = 'Half day on call cannot be applied.';
				   }

				}

				/*
					END- Validating Half day requests based on On call management options
				*/


				/*
				   START- Validating if oncall request has been previoulsy applied
				   I.Validating from and to dates to check whether previously
				   any on call has been raised with the same dates.
				   II.If full day on call is applied then fromdate and todate are passed as parameter to query.
				   III.If half day on call is applied then fromdate and fromdate are passed as a parameter to query.
				*/
				if($oncallday == 1)
				{
					$dateexists = $this->checkdateexists($from_date, $to_date,$userid);
					if(!empty($dateexists))
					{
						if($dateexists[0]['dateexist'] > 0)
						{
						   $errorflag = 'false';
						   $messagearray['to_date'] = ' On call has already been applied for the above dates.';
						}
					}
				}else if($oncallday == 2)
				{
					$dateexists = $this->checkdateexists($from_date, $from_date,$userid);
					if(!empty($dateexists))
					{
						if($dateexists[0]['dateexist'] > 0)
						{
						   $errorflag = 'false';
						   $messagearray['from_date'] = ' On call has already been applied for the above date.';
						}
					}
				}

				/*
				  END- Validating if oncall request has been previoulsy applied
				*/

				/* START Validating whether applied date is prior to date of joining */
					if($dateofjoining >= $from_date)
					{
						$errorflag = 'false';
						$messagearray['from_date'] = ' On call cannot be applied before date of joining.';
					}
					/* End */
      		else
      		{    
      		    $date1 = date_parse_from_format("Y-m-d", $from_date);
      		    $date2 = date_parse_from_format("Y-m-d", $to_date);
      		    $month1 = $date1["month"];
      		    $month2 = $date2["month"];
      
      		    if($month1 != $month2)
      		    {
      			    $errorflag = 'false';
      			    $messagearray['from_date'] = ' On call for different months must be requested separately.';
      		    }
      		}

				if($oncallday == 2)
				 $appliedoncallscount =  0.5;
				else if($oncallday == 1)
				 $appliedoncallscount = ($days !=''?$days:$appliedoncallsdaycount);

				if($errorflag == 'true')
				{
				    $data_array = array('user_id'=>$userid,
				                 'reason'=>$reason,
				                 'oncalltypeid'=>$oncalltypeid,
				                 'oncallday'=>$oncallday,
								 'from_date'=>$from_date,
								 'to_date'=>$to_date,
								 'oncallstatus'=>1,
								 'rep_mang_id'=>$reportingmanagerid,
				      			 'no_of_days'=>$availableoncalls,
								 'appliedoncallscount'=>$appliedoncallscount,
								 'createdby' => $userid,
								 'createddate' => gmdate("Y-m-d H:i:s"),
								 'modifiedby'=>$userid,
								 'modifieddate'=>gmdate("Y-m-d H:i:s"),
								 'isactive'=> 1
						);
				    //$final_array = array($userid,$userfullname,$useremail,$reportingmanagerid,$reportingmanageremail,$reportingmanagername,$oncalltypeid,$oncallday,$from_date,$to_date,$availableoncalls,$appliedoncallscount,$businessunitid);
					$Id = $this->saveoncallrequestdetails($data_array);
					/* Start Mailing Code */
							/* Mail to Reporting manager */
							$toemailArr = array($reportingmanageremail);
							if(!empty($toemailArr))
							{
								$options['subject'] = 'On call request for approval';
								$options['header'] = 'On Call Request';
								$options['fromEmail'] = DONOTREPLYEMAIL;
								$options['fromName'] = DONOTREPLYNAME;
								$options['toEmail'] = $toemailArr;
                                //$options['cc'] = $hremail;
								$options['toName'] = $reportingmanagername;
								$options['message'] = '<div>
												<div>On call request has been raised for your approval.</div>
												<div>Name : '.$userfullname.'</div>
												<div> No. of oncalls applied : '.$appliedoncallscount.'</div>
												<div>From : '.$from_date.'</div>
												<div>To : '.$to_date.'.</div>
												<div> Reason : '.$reason.'</div>
												</div>';
								//$options['cron'] = 'yes';
                                $result = sapp_Global::_sendEmail($options);
							}
							/* END */

							/* Mail to the applied employee*/
								$empemailArr = array($useremail);
								$options['subject'] = 'On call request';
								$options['header'] = 'Your on call details';
								$options['fromEmail'] = DONOTREPLYEMAIL;
								$options['fromName'] = DONOTREPLYNAME;
								$options['toEmail'] = $toemailArr;
                                //$options['cc'] = $hremail;
								$options['toName'] = $userfullname;
								$options['message'] = '<div>
												<div>Following are your oncall details. A mail has been sent to your project manager for approval.</div>
												<div>Name : '.$userfullname.'</div>
												<div> No. of oncalls applied : '.$appliedoncallscount.'</div>
												<div>From : '.$from_date.'</div>
												<div>To : '.$to_date.'.</div>
												<div> Reason : '.$reason.'</div>
												</div>';
								//$options['cron'] = 'yes';
                                $result = sapp_Global::_sendEmail($options);
							/* End */

							/* Mail to HR */
                            if (defined('LV_HR_'.$businessunitid) && $businessunitid !='')
						    {
							    $options['subject'] = 'On call request for approval';
								$options['header'] = 'On call Request ';
								$options['fromEmail'] = DONOTREPLYEMAIL;
								$options['fromName'] = DONOTREPLYNAME;
								$options['toEmail'] = constant('LV_HR_'.$businessunitid);
                                //$options['cc'] = $hremail;
								$options['toName'] = 'On call Management';
								$options['message'] = '<div>
												<div>On call request has been raised.</div>
												<div>Name : '.$userfullname.'</div>
												<div>No. of oncalls applied : '.$appliedoncallscount.'</div>
												<div>From : '.$from_date.'</div>
												<div>To : '.$to_date.'.</div>
												<div>Reason : '.$reason.'</div>
												<div>Reporting manager : '.$reportingmanagerName.'</div>
												</div>';
								$options['cron'] = 'yes';
                                $result = sapp_Global::_sendEmail($options);

							}

							/* END */
					/* End Mailing Code */
					$data = array('status'=>'1','message'=>'On call request saved successfully.','result' => 'success');
				}else
				{
					$data = array('status'=>'0','message'=>$messagearray,'result' => $result);
				}


		}else
		{
			if(empty($oncalldetails['repmanagerdetails']))
				$messagearray['rep_mang_id'] = 'Reporting manager is not assigned yet. Please contact your HR.';
		    if(empty($oncalldetails['availableoncalls']))
				$messagearray['rep_mang_id'] = 'You have not been allotted on call for this financial year. Please contact your HR.';
			 if(empty($oncalldetails['oncalltypes']))
				$messagearray['oncall_type_id'] = 'On Call types are not configured yet.';
			 if(empty($oncalldetails['weekdetails']))
			 {
				$messagearray['from_date'] = 'On call management options are not configured yet.';
				$messagearray['to_date'] = 'On call management options are not configured yet.';
			 }
            $data = array('status'=>'0','message'=>$messagearray,'result' => $result);
		}



	  }else
	  {
		if($userid == '')
           $messagearray['userid'] = 'User Id cannot be empty.';
		if($oncalltypeid == '')
           $messagearray['userid'] = 'On call type Id cannot be empty.';
		if($oncallday == '')
           $messagearray['userid'] = 'On call day cannot be empty.';

	     $data = array('status'=>'0','message'=>$messagearray,'result' => $result);
	  }
	  //echo "<pre>";print_r($data);exit;
	  return $data;
    }

	public function saveoncallrequestdetails($data)
	{

			$this->insert($data);
			$id=$this->getAdapter()->lastInsertId('main_oncallrequest');
			return $id;
	}

	public function getoncalldetails($userid)
    {
	   $result = array();
	   $repmanager_result = array();


	  if(isset($userid) && $userid != '')
	  {
	    $db = Zend_Db_Table::getDefaultAdapter();

        $emp_query = "SELECT e.date_of_joining,e.reporting_manager,e.businessunit_id,e.department_id FROM main_employees AS e WHERE (e.isactive = 1 AND e.user_id=".$userid.")";
        $emp_result = $db->query($emp_query)->fetch();
		//echo "<pre>";print_r($emp_result);exit;
		$available_oncalls_query = "SELECT `el`.`emp_oncall_limit` AS `oncalllimit`, el.emp_oncall_limit - el.used_oncalls AS `remainingoncalls` FROM `main_employeeoncalls` AS `el` WHERE (el.user_id=".$userid." AND el.alloted_year = now() AND el.isactive = 1)";
        $available_oncalls_result = $db->query($available_oncalls_query)->fetch();

		$oncalltype_query = "SELECT `l`.`id`, `l`.`oncalltype`, `l`.`numberofdays` from `main_employeeoncalltypes` AS `l` WHERE (l.isactive = 1)";
		$oncalltype_result = $db->query($oncalltype_query)->fetchAll();
		//echo "<pre>";print_r($oncalltype_result);exit;

		if($emp_result['reporting_manager'] !='')
		{
		   $repmanager_query = "SELECT u.id,u.userfullname,u.emailaddress FROM main_users AS u WHERE (u.isactive = 1 AND u.id=".$emp_result['reporting_manager'].")";
           $repmanager_result = $db->query($repmanager_query)->fetch();
		}

		if($emp_result['department_id'] !='')
		{
		   $weekdetails_query = "SELECT `l`.`weekend_startday` AS `weekendstartday`, `l`.`weekend_endday` AS `weekendday`,
								`l`.`is_halfday`, `l`.`is_oncalltransfer`, `l`.`is_skipholidays` FROM `main_oncallmanagement` AS `l`
								WHERE (l.department_id = ".$emp_result['department_id']." AND l.isactive = 1) ";
           $weekdetails_result = $db->query($weekdetails_query)->fetch();
		}


		$data = array('empdetails' => $emp_result,'repmanagerdetails' => $repmanager_result,'availableoncalls' =>$available_oncalls_result,'oncalltypes' => $oncalltype_result,'weekdetails' => $weekdetails_result);


	  }else
	  {
	     $data = array('status'=>'0','message'=>'User Id cannot be empty.','result' => $result);
	  }
	  //echo "<pre>";print_r($data);exit;
	  return $data;
    }

	public function canceloncall($userid,$recordid)
	{
	    $businessunitid = '';
		$from_date = '';
		$to_date = '';
		$reason = '';
		$appliedoncallscount = '';
		$userfullname = '';
		$useremail = '';
		$reportingmanagername = '';
		$reportingmanageremail = '';

	    $db = Zend_Db_Table::getDefaultAdapter();
		$date = gmdate("Y-m-d H:i:s");
		/* Fetching the record to be updated with cancel satus for email purpose and updating the status */
		if($userid !='' && $recordid !='')
		{
			$oncall_query = "SELECT l.reason,l.appliedoncallscount,DATE_FORMAT(l.from_date,'".DATEFORMAT_MYSQL."') as from_date,
							DATE_FORMAT(l.to_date,'".DATEFORMAT_MYSQL."') as to_date FROM main_oncallrequest AS l
							where (l.id=".$recordid." and l.user_id =".$userid." and l.isactive=1)";
			$oncall_result = $db->query($oncall_query)->fetch();
			//echo "<pre>";print_r($oncall_result);exit;
			if(!empty($oncall_result))
			{
			   $from_date = $oncall_result['from_date'];
			   $to_date = $oncall_result['to_date'];
			   if($to_date == '' || $to_date == NULL)
				$to_date = $from_date;
			   $reason = $oncall_result['reason'];
			   $appliedoncallscount = $oncall_result['appliedoncallscount'];
			}

			$db->query("update main_oncallrequest  set oncallstatus = 4,modifiedby = ".$userid.",
							modifieddate = '".$date."' where (id=".$recordid." and user_id =".$userid." and isactive=1 )");

			/* END */

			$user_query = "SELECT u.userfullname,u.emailaddress,e.businessunit_id,e.reporting_manager FROM main_users AS u
						   left join main_employees e on e.user_id=u.id
						   WHERE (u.isactive = 1 AND u.id=".$userid.")";
			$user_result = $db->query($user_query)->fetch();
			if(!empty($user_result))
			{
				 $userfullname = $user_result['userfullname'];
				 $useremail = $user_result['emailaddress'];
				 $businessunitid = $user_result['businessunit_id'];
				 $reportingmanagerid = $user_result['reporting_manager'];
			}

			if($reportingmanagerid  !='')
			{
				$rep_mangr_query = "SELECT u.userfullname,u.emailaddress FROM main_users AS u
									WHERE (u.isactive = 1 AND u.id=".$reportingmanagerid.")";
				$repmanager_result = $db->query($rep_mangr_query)->fetch();
				if(!empty($repmanager_result))
				{
					$reportingmanagername = $repmanager_result['userfullname'];
					$reportingmanageremail = $repmanager_result['emailaddress'];
				}
			}

			if($userfullname != ''&& $useremail != '' && $from_date != '' && $reason != '' && $appliedoncallscount !='')
			{

					/* Mail to Employee */
					$options['subject'] = 'On Call Request';
					$options['header'] = 'On Call Request';
					$options['fromEmail'] = DONOTREPLYEMAIL;
					$options['fromName'] = DONOTREPLYNAME;
					$options['toEmail'] = $useremail;
					//$options['cc'] = $hremail;
					$options['toName'] = $userfullname;
					$options['message'] = '<div>
											<div>Name : '.$userfullname.'</div>
											<div> No. of oncalls applied : '.$appliedoncallscount.'</div>
											<div>From : '.$from_date.'</div>
											<div>To : '.$to_date.'.</div>
											<div> Reason : '.$reason.'</div>
											</div>';
					$result = sapp_Global::_sendEmail($options);
					/* End */

					/* Mail to Reporting Manager */
					$options['subject'] = 'On Call Request';
					$options['header'] = 'On Call Request';
					$options['fromEmail'] = DONOTREPLYEMAIL;
					$options['fromName'] = DONOTREPLYNAME;
					$options['toEmail'] = $reportingmanageremail;
					//$options['cc'] = $hremail;
					$options['toName'] = $reportingmanagername;
					$options['message'] = '<div>
											<div>Name : '.$userfullname.'</div>
											<div> No. of oncalls applied : '.$appliedoncallscount.'</div>
											<div>From : '.$from_date.'</div>
											<div>To : '.$to_date.'.</div>
											<div> Reason : '.$reason.'</div>
											</div>';
					$result = sapp_Global::_sendEmail($options);
					/* End */

					/* Mail to HR */
					if (defined('LV_HR_'.$businessunitid) && $businessunitid !='')
					{

					$options['subject'] = 'On Call Request';
					$options['header'] = 'On Call Request';
					$options['fromEmail'] = DONOTREPLYEMAIL;
					$options['fromName'] = DONOTREPLYNAME;
					$options['toEmail'] = constant('LV_HR_'.$businessunitid);
					//$options['cc'] = $hremail;
					$options['toName'] = 'On call management';
					$options['message'] = '<div>
									<div>Name : '.$userfullname.'</div>
									<div> No. of oncalls applied : '.$appliedoncallscount.'</div>
									<div>From : '.$from_date.'</div>
									<div>To : '.$to_date.'.</div>
									<div> Reason : '.$reason.'</div>
									</div>';
					//$options['cron'] = 'yes';
					$result = sapp_Global::_sendEmail($options);
					}
					/*END */
			}

			$data = array('status'=>'1','message'=>'On call request cancelled successfully.','result' => 'success');
		}
		else
		  {
			 $data = array('status'=>'0','message'=>'User Id cannot be empty.','result' => $result);
		  }
		return $data;
	}

	public function getoncalltypedata($oncalltypeid)
	{
	    $data = array();
	    if($oncalltypeid)
		{
			$db = Zend_Db_Table::getDefaultAdapter();

			$oncalltype_query = "SELECT e.oncalltype,e.numberofdays FROM main_employeeoncalltypes AS e WHERE (e.isactive = 1 AND e.id=".$oncalltypeid.")";
			$data = $db->query($oncalltype_query)->fetch();
		}
		return $data;
	}

	public function calculatebusinessdaysoncall($fromDate,$toDate,$userid)
	{
	    $db = Zend_Db_Table::getDefaultAdapter();
	    $noOfDays =0;
		$weekDay='';
		$employeeDepartmentId = '';
		$employeeGroupId = '';
		$weekend1 = '';
		$weekend2 = '';
		$holidayDatesArr = array();
		//$fromDate = $this->_request->getParam('fromDate');
		//$toDate = $this->_request->getParam('toDate');
			//Calculating the no of days in b/w from date & to date with out taking weekend & holidays....
			//$employeesmodel = new Default_Model_Employees();
			//$oncallmanagementmodel = new Default_Model_Oncallmanagement();
			//$holidaydatesmodel = new Default_Model_Holidaydates();

			$emp_query = "SELECT e.holiday_group,e.department_id FROM main_employees AS e WHERE (e.isactive = 1 AND e.user_id=".$userid.")";
			$emp_result = $db->query($emp_query)->fetch();
			//$loggedInEmployeeDetails = $employeesmodel->getLoggedInEmployeeDetails($loginUserId);

			if(!empty($emp_result))
			{
				$employeeDepartmentId = $emp_result['department_id'];
				$employeeGroupId = $emp_result['holiday_group'];
				if($employeeDepartmentId !='' && $employeeDepartmentId !=NULL)
				{
					$weekend_query = "SELECT `l`.`weekend_startday` AS `weekendstartday`, `l`.`weekend_endday` AS `weekendday`, `l`.`is_halfday`, `l`.`is_oncalltransfer`, `l`.`is_skipholidays`, `w`.`week_name` AS `daystartname`, `wk`.`week_name` AS `dayendname` FROM `main_oncallmanagement` AS `l`
									 LEFT JOIN `tbl_weeks` AS `w` ON w.week_id=l.weekend_startday
									 LEFT JOIN `tbl_weeks` AS `wk` ON wk.week_id=l.weekend_endday WHERE (l.department_id = ".$employeeDepartmentId." AND l.isactive = 1)";
					$weekend_result = $db->query($weekend_query)->fetch();
				}
				//$weekendDetailsArr = $oncallmanagementmodel->getWeekendNamesDetails($employeeDepartmentId);
				if(!empty($weekend_result))
				{
					if($weekend_result['is_skipholidays'] == 1 && isset($employeeGroupId) && $employeeGroupId !='')
					{
					  //$holidayDateslistArr = $holidaydatesmodel->getHolidayDatesListForGroup($employeeGroupId);
					  $holidaylist_query = "SELECT `h`.`holidaydate` FROM `main_holidaydates` AS `h` WHERE (h.groupid = ".$employeeGroupId." AND h.isactive = 1)";
					  $holidayDateslistArr = $db->query($holidaylist_query)->fetchAll();
					  if(!empty($holidayDateslistArr))
					  {
						  for($i=0;$i<sizeof($holidayDateslistArr);$i++)
						   {
							  $holidayDatesArr[$i] = $holidayDateslistArr[$i]['holidaydate'];
						   }
					  }
					}

					$weekend1 = $weekend_result['daystartname'];
					$weekend2 = $weekend_result['dayendname'];
				}
				/*else
				{
				   $weekend1 = 'Saturday';
				   $weekend2 = 'Sunday';
				}*/


				$fromdate_obj = new DateTime($fromDate);
				$weekDay = $fromdate_obj->format('l');
				while($fromDate <= $toDate)
				{
					$noOfDays++;
					$fromdate_obj->add(new DateInterval('P1D'));	//Increment from date by one day...
					$fromDate = $fromdate_obj->format('Y-m-d');
					$weekDay = $fromdate_obj->format('l');
				}
			}

		return $noOfDays;

	}

	public function calculatedaysoncall($userid,$oncalltypetext='',$oncalltypelimit='',$oncallday,$from_date,$to_date='',$selectorid='')
	{
	    $messagearray = array();
		$db = Zend_Db_Table::getDefaultAdapter();
	    $noOfDays =0;
		$weekDay='';
		$employeeDepartmentId = '';
		$employeeGroupId = '';
		$weekend1 = '';
		$weekend2 = '';
		$holidayDatesArr = array();

		$fromDate = sapp_Global::change_date($from_date,'database');
		$from_obj = new DateTime($from_date);
		$from_date = $from_obj->format('Y-m-d');

		if($to_date !='')
		{
			$toDate = sapp_Global::change_date($to_date,'database');
			$to_obj = new DateTime($to_date);
		}
		else
		{
		  $toDate = sapp_Global::change_date($from_date,'database');
		  $to_obj = new DateTime($from_date);
		}
		$to_date = $to_obj->format('Y-m-d');

		if($oncallday == 1)
			{
				if($to_date >= $from_date)
				{
				    $emp_query = "SELECT e.holiday_group,e.department_id FROM main_employees AS e WHERE (e.isactive = 1 AND e.user_id=".$userid.")";
					$emp_result = $db->query($emp_query)->fetch();
					//$loggedInEmployeeDetails = $employeesmodel->getLoggedInEmployeeDetails($loginUserId);

					if(!empty($emp_result))
					{
						$employeeDepartmentId = $emp_result['department_id'];
						$employeeGroupId = $emp_result['holiday_group'];
						if($employeeDepartmentId !='' && $employeeDepartmentId !=NULL)
						{
						$weekend_query = "SELECT `l`.`weekend_startday` AS `weekendstartday`, `l`.`weekend_endday` AS `weekendday`, `l`.`is_halfday`, `l`.`is_oncalltransfer`, `l`.`is_skipholidays`, `w`.`week_name` AS `daystartname`, `wk`.`week_name` AS `dayendname` FROM `main_oncallmanagement` AS `l`
										 LEFT JOIN `tbl_weeks` AS `w` ON w.week_id=l.weekend_startday
										 LEFT JOIN `tbl_weeks` AS `wk` ON wk.week_id=l.weekend_endday WHERE (l.department_id = ".$employeeDepartmentId." AND l.isactive = 1)";
						$weekend_result = $db->query($weekend_query)->fetch();
						}
						//$weekendDetailsArr = $oncallmanagementmodel->getWeekendNamesDetails($employeeDepartmentId);

						if(!empty($weekend_result))
						{
							if($weekend_result['is_skipholidays'] == 1 && isset($employeeGroupId) && $employeeGroupId !='')
							{
							  //$holidayDateslistArr = $holidaydatesmodel->getHolidayDatesListForGroup($employeeGroupId);
							  $holidaylist_query = "SELECT `h`.`holidaydate` FROM `main_holidaydates` AS `h` WHERE (h.groupid = ".$employeeGroupId." AND h.isactive = 1)";
							  $holidayDateslistArr = $db->query($holidaylist_query)->fetchAll();
							  if(!empty($holidayDateslistArr))
							  {
								  for($i=0;$i<sizeof($holidayDateslistArr);$i++)
								   {
									  $holidayDatesArr[$i] = $holidayDateslistArr[$i]['holidaydate'];
								   }
							  }
							}
								$weekend1 = $weekend_result['daystartname'];
								$weekend2 = $weekend_result['dayendname'];
						}
						/*else
						{
						   $weekend1 = 'Saturday';
						   $weekend2 = 'Sunday';
						}*/


						$fromdate_obj = new DateTime($fromDate);
						$weekDay = $fromdate_obj->format('l');
						while($fromDate <= $toDate)
						{
							$noOfDays++;
							$fromdate_obj->add(new DateInterval('P1D'));	//Increment from date by one day...
							$fromDate = $fromdate_obj->format('Y-m-d');
							$weekDay = $fromdate_obj->format('l');
						}
					}
					$data = array('status'=>'1','message'=>'success','noOfDays' => $noOfDays);
				}else
				{
				   if($selectorid !='' && $selectorid == 1)
					{
						$messagearray['from_date'] = 'From date should be less than to date.';
					}
					else if($selectorid !='' && $selectorid == 2)
					{
						$messagearray['to_date'] = 'To date should be greater than from date.';
					}

					$data = array('status'=>'0','message'=>$messagearray,'noOfDays' => '');
				}
		}else if($oncallday == 2)
		{
		    $data = array('status'=>'1','message'=>'success','noOfDays' => 0.5);
		}
        return $data;
	}

	public function checkdateexists($from_date, $to_date,$userid)
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$result = array();
		if($from_date!='' && $to_date != '')
		{
			$query = "select count(l.id) as dateexist from main_oncallrequest l where l.user_id=".$userid." and l.oncallstatus IN(1,2) and l.isactive = 1
			and (l.from_date between '".$from_date."' and '".$to_date."' OR l.to_date between '".$from_date."' and '".$to_date."' )";

			$result = $db->query($query)->fetchAll();
		}
	    return $result;
	}



}
