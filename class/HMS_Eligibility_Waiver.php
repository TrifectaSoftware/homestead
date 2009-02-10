<?php

class HMS_Eligibility_Waiver{

    public $id = 0;
    public $asu_username;
    public $term;
    public $created_on;
    public $created_by;

    public function __construct($asu_username, $term)
    {

        $this->asu_username = $asu_username;
        $this->term = $term;
        $this->created_on = mktime();
        $this->created_by = Current_User::getUsername();
    }

    public function save()
    {
        $db = new PHPWS_DB('hms_eligibility_waiver');
        $result = $db->saveObject($this);

        if(!$result || PHPWS_Error::logIfError($result)){
            return false;
        }

        return true;
    }

    public function delete()
    {
        # TODO
    }

    public function getPageTags()
    {
        # TODO
    }

    /******************
     * Static methods *
     ******************/
    
    public function checkForWaiver($username, $term = NULL)
    {
        PHPWS_Core::initModClass('hms', 'HMS_Term.php');
        
        $db = new PHPWS_DB('hms_eligibility_waiver');
        $db->addWhere('asu_username', $username);

        if(!isset($term)){
            $db->addWhere('term', HMS_Term::get_current_term());
        }else{
            $db->addWhere('term', $term);
        }

        return !is_null($db->select('row'));
    }

    public function createWaiver()
    {
        
    }

    public function getPager()
    {
        #TODO
    }
}

?>