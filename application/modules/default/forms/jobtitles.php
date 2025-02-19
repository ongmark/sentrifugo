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

class Default_Form_jobtitles extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setAttrib('action',BASE_URL.'jobtitles/edit');
		$this->setAttrib('id', 'formid');
		$this->setAttrib('name', 'jobtitles');


        $id = new Zend_Form_Element_Hidden('id');
		$emptyflag = new Zend_Form_Element_Hidden('emptyFlag');
		
		$jobtitlecode = new Zend_Form_Element_Text('jobtitlecode');
        $jobtitlecode->setAttrib('maxLength', 20);
        $jobtitlecode->setRequired(true);
        $jobtitlecode->addValidator('NotEmpty', false, array('messages' => 'Please enter Career Track code.'));
		$jobtitlecode->addValidator("regex",true,array(
                           'pattern'=>'/^[a-zA-Z][a-zA-Z0-9\s]*$/', 
                           'messages'=>array(
                               'regexNotMatch'=>'Please enter valid Career Track code.'
                           )
        	));
        $jobtitlecode->addValidator(new Zend_Validate_Db_NoRecordExists(
                                              array('table'=>'main_jobtitles',
                                                        'field'=>'jobtitlecode',
                                                      'exclude'=>'id!="'.Zend_Controller_Front::getInstance()->getRequest()->getParam('id').'" and isactive=1',    
                                                 ) )  
                                    );
        $jobtitlecode->getValidator('Db_NoRecordExists')->setMessage('Career Track code already exists.'); 		
      
		$jobtitlename = new Zend_Form_Element_Text('jobtitlename');
        $jobtitlename->setAttrib('maxLength', 50);
        $jobtitlename->setRequired(true);
        $jobtitlename->addValidator('NotEmpty', false, array('messages' => 'Please enter Career Track.'));  
		$jobtitlename->addValidator("regex",true,array(
                           'pattern'=>'/^[a-zA-Z][a-zA-Z0-9\-\&\s]*$/', 
                           'messages'=>array(
                               'regexNotMatch'=>'Please enter valid Career Track.'
                           )
        	));
	
		$jobdescription = new Zend_Form_Element_Textarea('jobdescription');
        $jobdescription->setAttrib('rows', 10);
        $jobdescription->setAttrib('cols', 50);
		$jobdescription ->setAttrib('maxlength', '200');
		
		$minexperiencerequired = new Zend_Form_Element_Text('minexperiencerequired');
        $minexperiencerequired->setAttrib('maxLength', 4);
        $minexperiencerequired->addFilter(new Zend_Filter_StringTrim());
		$minexperiencerequired->addValidators(array(
						 array(
							 'validator'   => 'Regex',
							 'breakChainOnFailure' => true,
							 'options'     => array( 
							 'pattern'=>'/^[0-9]\d{0,1}(\.\d*)?$/', 
							  'messages' => array(
							  'regexNotMatch'=>'Please enter only numeric characters.'
								 )
							 )
						 )
					 )); 
        		
		$jobpaygradecode = new Zend_Form_Element_Text('jobpaygradecode');
        $jobpaygradecode->setAttrib('maxLength', 20);
        $jobpaygradecode->addFilter(new Zend_Filter_StringTrim());
        $jobpaygradecode->setRequired(true);
        $jobpaygradecode->addValidator('NotEmpty', false, array('messages' => 'Please enter job pay grade code.')); 
		
		$jobpayfrequency = new Zend_Form_Element_Select('jobpayfrequency');
        $jobpayfrequency->setLabel('Job Charge Frequency');
        $jobpayfrequency->addMultiOption('','Select Charge Frequency');		
		$jobpayfrequency->setRequired(true);
		$jobpayfrequency->addValidator('NotEmpty', false, array('messages' => 'Please select job Charge Frequency.')); 				
		$jobpayfrequency->setRegisterInArrayValidator(false);	
      		
		$comments = new Zend_Form_Element_Textarea('comments');
        $comments->setAttrib('rows', 10);
        $comments->setAttrib('cols', 50);
		$comments ->setAttrib('maxlength', '200');

        $submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		$submit->setLabel('Save');

		 $this->addElements(array($id,$jobtitlecode,$jobtitlename,$jobdescription,$minexperiencerequired,$emptyflag,$jobpaygradecode,$jobpayfrequency,$comments,$submit));
         $this->setElementDecorators(array('ViewHelper')); 
	}
}