<?php

namespace Homestead\Command;

use \Homestead\UserStatus;
use \Homestead\CommandFactory;
use \Homestead\NotificationView;
use \Homestead\HMS_Roommate;
use \Homestead\Exception\PermissionException;

/**
 * Compatibility layer for old Roommate code.
 * @author Jeff Tickle <jtickle at tux dot appstate dot edu>
 */

class ShowRequestRoommateCommand extends Command {

    private $term;

    public function getRequestVars()
    {
        $vars = array('action' => 'ShowRequestRoommate');

        if(isset($this->term)) {
            $vars['term'] = $this->term;
        }

        return $vars;
    }

    public function setTerm($term)
    {
        $this->term = $term;
    }

    public function execute(CommandContext $context)
    {
        if(!UserStatus::isUser()) {
            throw new PermissionException('You do not have permission to request a roommate.');
        }

        $term = $context->get('term');
        if(is_null($term)) {
            throw new \InvalidArgumentException('Must specify a term.');
        }

        $username = UserStatus::getUsername();

        $err = CommandFactory::getCommand('ShowStudentMenu');

        // Make sure the user doesn't already have a request pending
        $result = HMS_Roommate::has_roommate_request($username, $term);
        if($result === TRUE) {
            \NQ::simple('hms', NotificationView::WARNING, 'You have a pending roommate request. You can not request another roommate request until your current request is either denied or expires.');
            $err->redirect();
        }

        // Make sure the user doesn't already have a confirmed roommate
        $result = HMS_Roommate::has_confirmed_roommate($username, $term);
        if($result === TRUE) {
            \NQ::simple('hms', NotificationView::WARNING, 'You already have a confirmed roommate.');
            $err->redirect();
        }

        $form = new \PHPWS_Form;

        $cmd = CommandFactory::getCommand('RequestRoommate');
        $cmd->setTerm($term);
        $cmd->initForm($form);

        $form->addText('username');
        $form->addCssClass('username', 'form-control');
        $form->setExtra('username', 'autofocus');

        $form->addSubmit('submit', 'Request Roommate');

        $form->addButton('cancel', 'Cancel');
        $form->setExtra('cancel', 'onClick="document.location=\'index.php\'"');

        $tpl = $form->getTemplate();

        $context->setContent(\PHPWS_Template::process($tpl, 'hms', 'student/select_roommate.tpl'));
    }
}
