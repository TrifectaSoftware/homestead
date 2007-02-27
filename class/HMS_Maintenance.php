<?php

/**
 * Maintenance class for HMS
 *
 * @author Kevin Wilcox <kevin at tux dot appstate dot edu>
 */

class HMS_Maintenance
{

    function HMS_Maintenance()
    {
        $this->error = "";
    }
    
    function set_error_msg($msg)
    {
        $this->error .= $msg;
    }

    function get_error_msg()
    {
        return $this->error;
    }
    
    function purge_data()
    {
        $content = "Purging residence hall data...<br />";
        $db = &new PHPWS_DB('hms_residence_hall');
        $db->delete();

        $content .= "Purging floor data...<br />";
        $db = &new PHPWS_DB('hms_floor');
        $db->delete();

        $content .= "Purging room data...<br />";
        $db = &new PHPWS_DB('hms_room');
        $db->delete();

        $content .= "Done!<br />";
        return $content;
    }

    function show_options()
    {
        if(Current_User::allow('hms', 'hall_maintenance'))
            $tpl['HALL_LABEL']  = "Residence Hall Options";

        if(Current_User::allow('hms', 'add_halls')) 
            $tpl['ADD_HALL']    = PHPWS_Text::secureLink(_('Add Residence Hall'), 'hms', array('type'=>'hall', 'op'=>'add_hall'));

        if(Current_User::allow('hms', 'edit_halls')) 
            $tpl['EDIT_HALL']   = PHPWS_Text::secureLink(_('Edit Residence Hall'), 'hms', array('type'=>'hall', 'op'=>'select_residence_hall_for_edit'));

        if(Current_User::allow('hms', 'delete_halls'))
            $tpl['DELETE_HALL'] = PHPWS_Text::secureLink(_('Delete Residence Hall'), 'hms', array('type'=>'hall', 'op'=>'select_residence_hall_for_delete'));

        if(Current_User::allow('hms', 'floor_maintenance'))
            $tpl['FLOOR_LABEL'] = "Floor Options";

        if(Current_User::allow('hms', 'add_floors'))
            $tpl['ADD_FLOOR']   = PHPWS_Text::secureLink(_('Add a Floor to a Hall'), 'hms', array('type'=>'hall', 'op'=>'select_residence_hall_for_add_floor'));

        if(Current_User::allow('hms', 'edit_floors'))
            $tpl['EDIT_FLOOR']   = PHPWS_Text::secureLink(_('Edit a Floor'), 'hms', array('type'=>'floor', 'op'=>'select_hall_for_edit_floor'));
        
        if(Current_User::allow('hms', 'delete_floors'))
            $tpl['DELETE_FLOOR']   = PHPWS_Text::secureLink(_('Delete a Floor From a Hall'), 'hms', array('type'=>'hall', 'op'=>'select_residence_hall_for_delete_floor'));
       
        if(Current_User::allow('hms', 'room_maintenance'))
            $tpl['ROOM_LABEL'] = "Room Options";

        if(Current_User::allow('hms', 'edit_rooms'))
            $tpl['EDIT_ROOM'] = PHPWS_Text::secureLink(_('Edit a Room'), 'hms', array('type'=>'room', 'op'=>'select_hall_for_edit_room'));
        
        if(Current_User::allow('hms', 'learning_community_maintenance'))
            $tpl['LC_LABEL']    = "Learning Community Options";

        if(Current_User::allow('hms', 'add_learning_communities'))
            $tpl['ADD_LEARNING_COMMUNITY']      = PHPWS_Text::secureLink(_('Add Learning Community'), 'hms', array('type'=>'rlc', 'op'=>'add_learning_community')) . " &nbsp;*not implemented*";

        if(Current_User::allow('hms', 'edit_learning_communities'))
            $tpl['EDIT_LEARNING_COMMUNITY']     = PHPWS_Text::secureLink(_('Edit Learning Community'), 'hms', array('type'=>'rlc', 'op'=>'edit_learning_community')) . " &nbsp;*not implemented*";

        if(Current_User::allow('hms', 'delete_learning_communities'))
            $tpl['DELETE_LEARNING_COMMUNITY']   = PHPWS_Text::secureLink(_('Delete Learning Community'), 'hms', array('type'=>'rlc', 'op'=>'select_learning_community_for_delete')) . " &nbsp;*not implemented*";

        if(Current_User::allow('hms', 'rlc_applicant_options')) 
            $tpl['RLC_APPLICATIONS']    = "RLC Applicant Options";

        if(Current_User::allow('hms', 'assign_rlc_applicants')) 
            $tpl['ASSIGN_RLC_APPLICANTS']    = PHPWS_Text::secureLink(_('Assign RLC Applicants'), 'hms', array('type'=>'rlc', 'op'=>'assign_applicants'));

        if(Current_User::allow('hms', 'view_rlc_assignments')) 
            $tpl['VIEW_RLC_ASSIGNMENTS']    = PHPWS_Text::secureLink(_('View RLC Assignments'), 'hms', array('type'=>'rlc', 'op'=>'view_assignments'));

        if(Current_User::allow('hms', 'student_maintenance'))
            $tpl['STUDENT_LABEL'] = "Student Maintenance";

        if(Current_User::allow('hms', 'add_student'))
            $tpl['ADD_STUDENT']     = PHPWS_Text::secureLink(_('Add Student'), 'hms', array('type'=>'student', 'op'=>'add_student'));

        if(Current_User::allow('hms', 'edit_student'))
            $tpl['EDIT_STUDENT']    = PHPWS_Text::secureLink(_('Edit Student'), 'hms', array('type'=>'student', 'op'=>'enter_student_search_data'));

        if(Current_User::allow('hms', 'deadline_maintenance'))
            $tpl['DEADLINE_LABEL']  = "Deadline Maintenance";

        if(Current_User::allow('hms', 'edit_deadlines')) 
            $tpl['EDIT_DEADLINES']  = PHPWS_Text::secureLink(_('Edit Deadlines'), 'hms', array('type'=>'maintenance', 'op'=>'show_deadlines'));

        if(Current_User::allow('hms', 'assignment_maintenance'))
            $tpl['ASSIGNMENT_LABEL'] = "Assignment Maintenance";

        if(Current_User::allow('hms', 'create_assignment'))
            $tpl['CREATE_ASSIGNMENT'] = PHPWS_Text::secureLink(_('Assign Student'), 'hms', array('type'=>'assignment', 'op'=>'begin_create_assignment'));

        if(Current_User::allow('hms', 'delete_assignment'))
            $tpl['DELETE_ASSIGNMENT'] = PHPWS_Text::secureLink(_('Delete Room Assignment'), 'hms', array('type'=>'assignment', 'op'=>'begin_delete_assignment'));

        if(Current_User::allow('hms', 'roommate_maintenance'))
            $tpl['ROOMMATE_LABEL'] = "Roommate Maintenance";

        if(Current_User::allow('hms', 'create_roommate_group'))
            $tpl['CREATE_ROOMMATE_GROUP'] = PHPWS_Text::secureLink(_('Create new roommate group'), 'hms', array('type'=>'roommate', 'op'=>'get_usernames_for_new_grouping'));

        if(Current_User::allow('hms', 'edit_roommate_group'))
            $tpl['EDIT_ROOMMATE_GROUP'] = PHPWS_Text::secureLink(_('Edit roommate group'), 'hms', array('type'=>'roommate', 'op'=>'get_username_for_edit_grouping'));
        
        if(Current_User::deityAllow()) 
            $tpl['PURGE_DATA'] = PHPWS_Text::secureLink(_('Purge data'), 'hms', array('type'=>'maintenance', 'op'=>'purge'));

       $content = PHPWS_Template::process($tpl, 'hms', 'admin/maintenance.tpl');
        return $content;
    }

    function show_deadlines($message = NULL)
    {
        PHPWS_Core::initModClass('hms', 'HMS_Forms.php');
        $form = &new HMS_Form;
        $content = $form->show_deadlines($message);
        return $content;
    }
        
    function save_deadlines()
    {
        $slbd   = $_REQUEST['student_login_begin_day'];
        $slbm   = $_REQUEST['student_login_begin_month'];
        $slby   = $_REQUEST['student_login_begin_year'];
        $slbt   = mktime(0,0,0,$slbm,$slbd,$slby);

        $sled   = $_REQUEST['student_login_end_day'];
        $slem   = $_REQUEST['student_login_end_month'];
        $sley   = $_REQUEST['student_login_end_year'];
        $slet   = mktime(0,0,0,$slem,$sled,$sley);

        $sabd    = $_REQUEST['submit_application_begin_day'];
        $sabm    = $_REQUEST['submit_application_begin_month'];
        $saby    = $_REQUEST['submit_application_begin_year'];
        $sabt    = mktime(0,0,0,$sabm,$sabd,$saby);

        $saed    = $_REQUEST['submit_application_end_day'];
        $saem    = $_REQUEST['submit_application_end_month'];
        $saey    = $_REQUEST['submit_application_end_year'];
        $saet    = mktime(0,0,0,$saem,$saed,$saey);

        $eaed   = $_REQUEST['edit_application_end_day'];
        $eaem   = $_REQUEST['edit_application_end_month'];
        $eaey   = $_REQUEST['edit_application_end_year'];
        $eaet   = mktime(0,0,0,$eaem,$eaed,$eaey);
        
        $spbd   = $_REQUEST['search_profiles_begin_day'];
        $spbm   = $_REQUEST['search_profiles_begin_month'];
        $spby   = $_REQUEST['search_profiles_begin_year'];
        $spbt   = mktime(0,0,0,$spbm,$spbd,$spby);

        $sped   = $_REQUEST['search_profiles_end_day'];
        $spem   = $_REQUEST['search_profiles_end_month'];
        $spey   = $_REQUEST['search_profiles_end_year'];
        $spet   = mktime(0,0,0,$spem,$sped,$spey);

        $sred   = $_REQUEST['submit_rlc_application_end_day'];
        $srem   = $_REQUEST['submit_rlc_application_end_month'];
        $srey   = $_REQUEST['submit_rlc_application_end_year'];
        $sret   = mktime(0,0,0,$srem,$sred,$srey);

        $vabd   = $_REQUEST['view_assignment_begin_day'];
        $vabm   = $_REQUEST['view_assignment_begin_month'];
        $vaby   = $_REQUEST['view_assignment_begin_year'];
        $vabt   = mktime(0,0,0,$vabm,$vabd,$vaby);

        $vaed   = $_REQUEST['view_assignment_end_day'];
        $vaem   = $_REQUEST['view_assignment_end_month'];
        $vaey   = $_REQUEST['view_assignment_end_year'];
        $vaet   = mktime(0,0,0,$vaem,$vaed,$vaey);

        $db = &new PHPWS_DB('hms_deadlines');
        $db->addColumn('student_login_begin_timestamp');
        $results = $db->select();
        unset($db);

        $db = &new PHPWS_DB('hms_deadlines');
        $db->addValue('student_login_begin_timestamp', $slbt);
        $db->addValue('student_login_end_timestamp', $slet);
        $db->addValue('submit_application_begin_timestamp', $sqbt);
        $db->addValue('submit_application_end_timestamp', $sqet);
        $db->addValue('edit_application_end_timestamp', $eaet);
        $db->addValue('search_profiles_begin_timestamp', $sebt);
        $db->addValue('search_profiles_end_timestamp', $seet);
        $db->addValue('submit_rlc_application_end_timestamp', $sret);
        $db->addValue('view_assignment_begin_timestamp', $vabt);
        $db->addValue('view_assignment_end_timestamp', $vaet);
        $db->addValue('updated_on',mktime());
        $db->addValue('updated_by', Current_User::getId());

        if($results == NULL) {
            $result = $db->insert();
        } else {
            $result = $db->update();
        }

        if(PEAR::isError($result)) {
            PHPWS_Error::log();
            $message = "Error saving deadlines. Please check the error logs!<br />";
            return HMS_Maintenance::show_deadlines($message);
        } else {
            $message = "Deadlines updated successfully!<br />";
            return HMS_Maintenance::show_deadlines($message);
        }
    }

    function main()
    {
        switch($_REQUEST['op'])
        {
            case 'show_maintenance_options':
                return HMS_Maintenance::show_options();
                break;
            case 'purge':
                return HMS_Maintenance::purge_data();
                break;
            case 'show_deadlines':
                return HMS_Maintenance::show_deadlines();
                break;
            case 'save_deadlines':
                return HMS_Maintenance::save_deadlines();
                break;
            default:
                break;
        }
    } 
};
?>
