<?php

class LotteryConfirmedRoommateThanksView extends View {
    
    private $invite;
    private $bed;
    
    public function __construct($invite, $bed){
        $this->invite = $invite;
        $this->bed = $bed;
    }
    
    public function show()
    {
        $tpl = array();
        
        $tpl['SUCCESS'] = 'Your roommate request was successfully confirmed. You have been assigned to ' . $this->bed->where_am_i() . ".";
        $tpl['LOGOUT_LINK'] = UserStatus::getLogoutLink();
        
        $mainMenuCmd = CommandFactory::getCommand('ShowStudentMenu');
        $tpl['MAIN_MENU'] = $mainMenuCmd->getLink('Return to the main menu');

        return PHPWS_Template::process($tpl, 'hms', 'student/student_success_failure_message.tpl');
    }
}