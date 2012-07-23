<?php

/**
 *
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

class AppliedStudentData extends Report implements iCsvReport {
    const friendlyName = 'Applied Student Data Export';
    const shortName = 'AppliedStudentData';

    private $term;
    private $rows;

    public function setTerm($term)
    {
        $this->term = $term;
    }

    public function getTerm()
    {
        return $this->term;
    }

    public function execute()
    {
        PHPWS_Core::initModClass('hms', 'HousingApplicationFactory.php');
        PHPWS_Core::initModClass('hms', 'HMS_Assignment.php');
        PHPWS_Core::initModClass('hms', 'StudentFactory.php');

        $db = new PHPWS_DB('hms_new_application');
        $db->addWhere('term', $this->term);

        $result = $db->select();
        
        $apps = array();

        foreach ($result as $app) {

            $username   = $app['username'];
            $bannerId   = $app['banner_id'];
            $type       = $app['student_type'];
            $cellPhone  = $app['cell_phone'];

            $assignment = HMS_Assignment::getAssignmentByBannerId($bannerId, $this->term);

            if(!is_null($assignment)){
                $room = $assignment->where_am_i();
            }else{
                $room = '';
            }

            $student = StudentFactory::getStudentByUsername($username, $this->term);

            $first  = $student->getFirstName($username);
            $middle = $student->getMiddleName($username);
            $last   = $student->getLastName($username);

            $address = $student->getAddress(NULL);

            $this->rows[] =
                    array(
                        $username, $bannerId, $first, $middle, $last,
                        $type, $cellPhone, $room, $address->line1, $address->line2,
                        $address->line3, $address->city,
                        $address->state, $address->zip
                    );
        }
    }

    public function getCsvColumnsArray()
    {
        return array('Username', 'Banner id', 'First name', 'Middle name',
            'Last name', 'Student type', 'Cell Phone', 'Assignment', 'Address 1',
            'Address 2', 'Address 3', 'City', 'State', 'Zip');
    }

    public function getCsvRowsArray()
    {
        return $this->rows;
    }

    public function getDefaultOutputViewCmd()
    {
        $cmd = CommandFactory::getCommand('ShowReportCsv');
        $cmd->setReportId($this->id);

        return $cmd;
    }
}
?>