<?php

namespace Homestead;

class RoomChangeListView extends View {

    private $requests;
    private $term;

    public function __construct(Array $roomChangeRequests, $term)
    {
        $this->requests = $roomChangeRequests;
        $this->term = $term;
    }

    public function show()
    {
        $tpl = array();

        // Check for an empty array of requests
        if (sizeof($this->requests) == 0) {
            $tpl['NO_REQUESTS'] = 'No pending requests found.';
            return \PHPWS_Template::process($tpl, 'hms', 'admin/roomChangeListView.tpl');
        }

        javascriptMod('hms', 'livestamp');

        $tpl['REQUESTS'] = array();
        foreach($this->requests as $request){
            $row = array();

            $participants = $request->getParticipants();

            $participantNames = array();
            foreach ($participants as $p){
                $student = StudentFactory::getStudentByBannerId($p->getBannerId(), $this->term);
                $participantNames[] = $student->getName();
            }

            $row['participants'] = implode(', ', $participantNames);
            $mgmtCmd = CommandFactory::getCommand('ShowManageRoomChange');
            $mgmtCmd->setRequestId($request->getId());

            $row['manage'] = $mgmtCmd->getURI();
            $row['last_updated_timestamp'] = $request->getLastUpdatedTimestamp();
            $row['last_updated_date'] = date("M j @ g:ia", $request->getLastUpdatedTimestamp());

            $tpl['REQUESTS'][] = $row;
        }

        return \PHPWS_Template::process($tpl, 'hms', 'admin/roomChangeListView.tpl');
    }
}
