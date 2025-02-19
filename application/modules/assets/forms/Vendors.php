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
 * This gives vendor details form.
 */
class Assets_Form_Vendors extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
		$this->setAttrib('action',BASE_URL.'vendors/edit');
        $this->setAttrib('id', 'formid');
        $this->setAttrib('name', 'frm_vendor');
		

        $id = new Zend_Form_Element_Hidden('id');
		
	    $name = new Zend_Form_Element_Text('name');
        $name->setAttrib('maxLength', 50);
        $name->setAttrib('title', 'Vendor Name');        
        $name->addFilter(new Zend_Filter_StringTrim());
        $name->setRequired(true);
        $name->addValidator('NotEmpty', false, array('messages' => 'Please enter vendor name.'));  
        $name->addValidator("regex",true,array(                           
                           'pattern'=>'/^(?![0-9]*$)[a-zA-Z0-9.,&\(\)\/\-_\' ?]+$/',
                           'messages'=>array(
                               'regexNotMatch'=>'Please enter valid vendor name.'
                           )
        	));  
        $contactperson = new Zend_Form_Element_Text('contact_person');
        $contactperson->setAttrib('maxLength', 50);
        $contactperson->setAttrib('title', 'Contact Person');        
        $contactperson->addFilter(new Zend_Filter_StringTrim());
		$contactperson->setRequired(true);
        $contactperson->addValidator('NotEmpty', false, array('messages' => 'Please enter contact person.'));
		$contactperson->addValidator("regex",true,array(                           
                           'pattern'=>'/^[a-zA-Z.\- ?]+$/',
                           'messages'=>array(
                               'regexNotMatch'=>'Please enter valid contact name.'
                           )
        	)); 
		 
		$address = new Zend_Form_Element_Textarea('address');
        $address->setAttrib('rows', 10);
        $address->setAttrib('cols', 50);
       
		
       
        
        $primary_phone = new Zend_Form_Element_Text('primary_phone');
		
		
        $primary_phone->setAttrib('maxLength', 15);
        $primary_phone->setAttrib('title', 'Primary Phone');        
        $primary_phone->addFilter(new Zend_Filter_StringTrim());
		$primary_phone->setRequired(true);
        $primary_phone->addValidator('NotEmpty', false, array('messages' => 'Please enter Primary Phone number.'));  
        $primary_phone->addValidator("regex",true,array(                           
                           
                           
                            'pattern'=>'/^\+?\d+$/',
                           'messages'=>array(
                           
                               'regexNotMatch'=>'Please enter valid Phone number.'
                           )
        	));
      
        $secondary_phone = new Zend_Form_Element_Text('secondary_phone');
		
		
		
		
        $secondary_phone->setAttrib('maxLength', 15);
        $secondary_phone->setAttrib('title', 'secondary Phone');        
        $secondary_phone->addFilter(new Zend_Filter_StringTrim());
        $secondary_phone->addValidator('NotEmpty', false, array('messages' => 'Please enter  Phone number.'));  
        $secondary_phone->addValidator("regex",true,array(                           
                           
                           
                            'pattern'=>'/^\+?\d+$/',
                           'messages'=>array(
                           
                               'regexNotMatch'=>'Please enter valid Phone number.'
                           )
        	));
      
              
        $country = new Zend_Form_Element_Select("country");
        $country->setRegisterInArrayValidator(false);
        $country->setLabel("Country");	
        $country->setRequired(true);		
        $country->setAttrib("class", "formDataElement"); 
        $country->setAttrib('onchange', 'displayParticularState_normal(this,"","state","city")');
        $country->setAttrib('title', 'Country');
       
        
        $country->addValidator('NotEmpty', false, array('messages' => 'Please select country.'));
		
        $state = new Zend_Form_Element_Select("state");
        $state->setRegisterInArrayValidator(false);
        
        
		$state->addValidator('NotEmpty', false, array('messages' => 'Please select state.')); 
        $state->addMultiOptions(array(''=>'Select State'));
        $state->setLabel("State");	
        $state->setRequired(true);		
        $state->setAttrib("class", "formDataElement"); 
        $state->setAttrib('onchange', 'displayParticularCity_normal(this,"","city","")');
        $state->setAttrib('title', 'State'); 		
        
        $city = new Zend_Form_Element_Select("city");
        $city->setRegisterInArrayValidator(false);
        $city->addMultiOptions(array(''=>'Select City'));
        $city->setLabel("City");
        $city->setRequired(true);		
        $city->setAttrib("class", "formDataElement");         
        $city->setAttrib('title', 'City');
        
		
		
        
        $pincode = new Zend_Form_Element_Text('pincode');
        $pincode->setLabel('Pin Code');
        $pincode->setAttrib('maxLength', 6);		
        $pincode->addValidator('NotEmpty', true, array('messages' => 'Please enter pincode.')); 
        $pincode->addValidator("regex",true,array(                           
                            'pattern'=>'/^(?!0{3})[0-9a-zA-Z]+\d+$/',
                            'messages'=>array(
                              'regexNotMatch'=>'Enter valid  pincode.'
                           )
        	));
        $pincode->setRequired(true);			
		//$pincode->addValidator('NotEmpty', false, array('messages' => 'Please enter postal code.'));
        
         /*  
			$pincode->addValidator('NotEmpty', false, array('messages' => 'Please enter postal code.')); 
			$pincode->addValidators(array(array('StringLength',false,
                                  array('min' => 6,
                                  		'max' => 6,
                                        'messages' => array(
                                        Zend_Validate_StringLength::TOO_LONG =>
                                        'Postal code must contain at most %max% characters.',
                                        Zend_Validate_StringLength::TOO_SHORT =>
                                        'Postal code must contain at least %min% characters.')))));
			$pincode->addValidator("regex",true,array(  
                            'pattern'=>'/^(?!0{3})[0-9a-zA-Z]+$/', 		
                           /^[0-9]|([0-9]+[a-zA-Z]+|[a-zA-Z]+[0-9]+)[0-9a-zA-Z]*$/
                            'messages'=>array(
                               'regexNotMatch'=>'Please enter valid postal code.'
                           )
        	)); */

                        
        $submit = new Zend_Form_Element_Submit('submit');        
        $submit->setAttrib('id', 'submitbutton');
		$submit->setAttrib('class', 'cvsbmtbtn');
        $submit->setLabel('Save'); 
        
       
		
        $this->addElements(array($id,$name,$contactperson,$address,$primary_phone,$secondary_phone,$country,$state,$city,$pincode,$submit));
        $this->setElementDecorators(array('ViewHelper')); 
    }
}