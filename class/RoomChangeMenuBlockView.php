<?php

class RoomChangeMenuBlockView extends View {

    private $student;
    private $startDate;
    private $endDate;
    private $assignment;
    private $changeRequest;

    public function __construct(Student $student, $term, $startDate, $endDate, HMS_Assignment $assignment = null, RoomChangeRequest $request = null)
    {
        $this->student          = $student;
        $this->term             = $term;
        $this->startDate        = $startDate;
        $this->endDate          = $endDate;
        $this->assignment       = $assignment;
        $this->changeRequest    = $request;
    }

    public function show()
    {
        $tpl = array();

        PHPWS_Core::initModClass('hms', 'HMS_Util.php');
        $tpl['DATES'] = HMS_Util::getPrettyDateRange($this->startDate, $this->endDate);

        if (time() < $this->startDate) { // too early
            $tpl['BEGIN_DEADLINE'] = HMS_Util::getFriendlyDate($this->startDate);
            $tpl['ICON'] = FEATURE_NOTYET_ICON;
        } else if (time() > $this->endDate){ // too late
            $tpl['ICON'] = FEATURE_LOCKED_ICON;
            $tpl['END_DEADLINE'] = HMS_Util::getFriendlyDate($this->endDate);
        } else if (is_null($this->assignment)){ // Not assigned anywhere
            $tpl['ICON'] = FEATURE_NOTYET_ICON;
            $tpl['NOT_ASSIGNED'] = "";
        } else if (!is_null($this->changeRequest) && !($this->changeRequest->getState() instanceof CompletedChangeRequest) && !($this->changeRequest->getState() instanceof DeniedChangeRequest)){ // has pending request
            $tpl['ICON'] = FEATURE_OPEN_ICON;
            $tpl['PENDING'] = "";
        } else {
            $tpl['ICON'] = FEATURE_OPEN_ICON;
            $changeReqCmd = CommandFactory::getCommand('ShowRoomChangeRequestForm');

            $tpl['NEW_REQUEST'] = $changeReqCmd->getLink('request a room change');
        }

        return PHPWS_Template::process($tpl, 'hms', 'student/menuBlocks/roomChangeMenuBlock.tpl');
    }
}

?>
