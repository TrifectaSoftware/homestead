<?php

namespace Homestead;

class DamageMenuBlockView extends View {

    private $student;
    private $startDate;
    private $endDate;
    private $assignment;
    private $changeRequest;

    public function __construct(Student $student, $term, $startDate, $endDate, HMS_Assignment $assignment = null)
    {
        $this->student          = $student;
        $this->term             = $term;
        $this->startDate        = $startDate;
        $this->endDate          = $endDate;
        $this->assignment       = $assignment;
    }

    public function show()
    {
        $checkin = CheckinFactory::getCheckinByBannerId($this->student->getBannerId(), $this->term);


        $tpl = array();
        $end = 0;

        if($checkin != null) {
            $end = strtotime(RoomDamage::SELF_REPORT_DEADLINE, $checkin->getCheckinDate());
        }

        $tpl['DATES'] = HMS_Util::getPrettyDateRange($this->startDate, $this->endDate);

        if (time() > $end){ // too late
            $tpl['ICON'] = FEATURE_LOCKED_ICON;
            if($end === 0) {
                $tpl['NO_CHECKIN'] = ''; // Dummy template var, text is in template
            } else {
                $tpl['END_DEADLINE'] = HMS_Util::get_long_date_time($end);
            }

        } else {
            $tpl['ICON'] = FEATURE_OPEN_ICON;
            $addRoomDmgsCmd = CommandFactory::getCommand('ShowStudentAddRoomDamages');
            $addRoomDmgsCmd->setTerm($this->term);

            $tpl['NEW_REQUEST'] = $addRoomDmgsCmd->getLink('add room damages');
            $tpl['DEADLINE'] = HMS_Util::get_long_date_time($end);
        }

        return \PHPWS_Template::process($tpl, 'hms', 'student/menuBlocks/roomDamageMenuBlock.tpl');
    }
}
