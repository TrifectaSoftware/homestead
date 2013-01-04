<?php

PHPWS_Core::initModClass('hms', 'CommandMenu.php');
PHPWS_Core::initModClass('hms', 'HMS_Permission.php');

class ServiceDeskMenu extends CommandMenu {
	
	public function __construct()
	{
		parent::__construct();
		
		if(UserStatus::isAdmin()){
			if(Current_User::allow('hms', 'checkin')){
				$this->addCommandByName('Check-in', 'ShowCheckinStart');
			}
			
			/*
			 * TODO
			if(Current_User::allow('hms', 'checkout')){
				$this->addCommandByName('Check-out', 'ShowCheckoutStart');
			}
			*/
		}
	}
	
	public function show()
	{
		if(empty($this->commands)){
			return '';
		}
		
		$tpl = array();
		
		$tpl['MENU'] = parent::show();
		$tpl['LEGEND_TITLE'] = 'Service Desk';
		$tpl['ICON_CLASS']   = 'tango-edit-paste';
		
		return PHPWS_Template::process($tpl, 'hms', 'admin/menus/AdminMenuBlock.tpl');
	}
}

?>