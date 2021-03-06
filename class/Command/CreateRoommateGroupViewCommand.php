<?php

namespace Homestead\Command;

use \Homestead\UserStatus;
use \Homestead\CreateRoommateGroupView;
use \Homestead\Exception\PermissionException;

class CreateRoommateGroupViewCommand extends Command {

    private $roommate1;
    private $roommate2;

    public function setRoommate1($username){
        $this->roommate1 = $username;
    }

    public function setRoommate2($username){
        $this->roommate2 = $username;
    }

    public function getRequestVars(){
        $vars = array('action'=>'CreateRoommateGroupView');

        if(!isset($this->roommate1)){
            $vars['roommate1'] = $this->roommate1;
        }

        if(!isset($this->roommate2)){
            $vars['roommate2'] = $this->roommate2;
        }

        return $vars;
    }

    public function execute(CommandContext $context)
    {

        if(!UserStatus::isAdmin() || !\Current_User::allow('hms', 'roommate_maintenance')){
            throw new PermissionException('You do not have permission to create/edit roommate groups.');
        }

        $createView = new CreateRoommateGroupView($context->get('roommate1'), $context->get('roommate2'));

        $context->setContent($createView->show());
    }
}
