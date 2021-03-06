<?php
namespace Homestead\Command;

use \Homestead\ShowHallNotificationSelectView;

/**
 * ShowHallNotificationSelectCommand
 *
 *     Shows the interface for selecting hall(s) to notify.
 *
 * @author Daniel West <lw77517 at appstate dot edu>
 * @package mod
 * @subpackage hms
 */

class ShowHallNotificationSelectCommand extends Command {

    public function getRequestVars(){
        $vars = array('action'=>'ShowHallNotificationSelect');

        return $vars;
    }

    public function execute(CommandContext $context){
        $view = new ShowHallNotificationSelectView();
        $context->setContent($view->show());
    }
}
