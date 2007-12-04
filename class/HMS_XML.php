<?php

require_once('XML/Serializer.php');

class HMS_XML{


    function main(){

        $op = $_REQUEST['op'];

        switch($op){
            case 'get_halls':
            
                HMS_XML::getHalls();
                break;
            case 'get_halls_with_vacancies':
                HMS_XML::getHallsWithVacancies();
                break;
            case 'get_floors':
            
                if(!isset($_REQUEST['hall_id'])){
                    # TODO: Find a way to throw an error here
                }else{
                    HMS_XML::getFloors($_REQUEST['hall_id']);
                }
                break;
            case 'get_floors_with_vacancies':
                HMS_XML::getFloorsWithVacancies($_REQUEST['hall_id']);
                break;
            case 'get_rooms': 
                if(!isset($_REQUEST['floor_id'])){
                    # TODO: Find a way to throw an error here
                }else{
                    HMS_XML::getRooms($_REQUEST['floor_id']);
                }
                break;
            case 'get_rooms_with_vacancies':
                HMS_XML::getRoomsWithVacancies($_REQUEST['floor_id']);
                break; 
            case 'get_bedrooms_with_vacancies':
                HMS_XML::getBedroomsWithVacancies($_REQUEST['room_id']);
                break;
            case 'get_beds_with_vacancies':
                HMS_XML::getBedsWithVacancies($_REQUEST['bedroom_id']);
                break;
            default:
                # No such 'op', or no 'op' specified
                # TODO: Find a way to throw an error here
                die('unknown op');
                break;
        }

    }

    function getHalls(){
        
        PHPWS_Core::initModClass('hms','HMS_Residence_Hall.php');
        
        $halls = HMS_Residence_Hall::get_halls();

        if(!$halls){
            // throw an error
        }

        $xml_halls = array();

        foreach($halls as $hall){
            $xml_halls[] = array('id' => $hall->id, 'name' => $hall->hall_name);
        }
        
        #test($xml_halls,1);

        $serializer_options = array (
            'addDecl' => TRUE,
            'encoding' => 'ISO-8859-1',
            'indent' => '  ',
            'rootName' => 'halls',
            'defaultTagName' => 'hall',); 

        $serializer = &new XML_Serializer($serializer_options);

        $status = $serializer->serialize($xml_halls);

        if(PEAR::isError($status)){
                die($status->getMessage());
        }

        header('Content-type: text/xml');
        echo $serializer->getSerializedData();
        exit;
    }


    function getHallsWithVacancies(){
        
        PHPWS_Core::initModClass('hms','HMS_Residence_Hall.php');
        
        $halls = HMS_Residence_Hall::get_halls_with_vacancies();

        if(!$halls){
            // throw an error
        }

        $xml_halls = array();

        foreach($halls as $hall){
            $xml_halls[] = array('id' => $hall->id, 'name' => $hall->hall_name);
        }
        
        #test($xml_halls,1);

        $serializer_options = array (
            'addDecl' => TRUE,
            'encoding' => 'ISO-8859-1',
            'indent' => '  ',
            'rootName' => 'halls',
            'defaultTagName' => 'hall',); 

        $serializer = &new XML_Serializer($serializer_options);

        $status = $serializer->serialize($xml_halls);

        if(PEAR::isError($status)){
                die($status->getMessage());
        }

        header('Content-type: text/xml');
        echo $serializer->getSerializedData();
        exit;
    }

    function getFloors($building_id){

        PHPWS_Core::initModClass('hms', 'HMS_Residence_Hall.php');

        $hall = &new HMS_Residence_Hall($building_id);

        $floors = $hall->get_floors();

        if(!$floors){
            // throw an error
        }
       
        $xml_floors = array();
        
        foreach ($floors as $floor){
            $xml_floors[] = array('id' => $floor->id, 'floor_num' => $floor->floor_number);
        }
        
        $serializer_options = array (
            'addDecl' => TRUE,
            'encoding' => 'ISO-8859-1',
            'indent' => '  ',
            'rootName' => 'floors',
            'defaultTagName' => 'floor',);

        $serializer = &new XML_Serializer($serializer_options);

        $status = $serializer->serialize($xml_floors);

        if(PEAR::isError($status)){
            die($status->getMessage());
        }

        header('Content-type: text/xml');
        echo $serializer->getSerializedData();
        exit;
    }

    function getFloorsWithVacancies($building_id){

        PHPWS_Core::initModClass('hms', 'HMS_Residence_Hall.php');

        $hall = &new HMS_Residence_Hall($building_id);

        $floors = $hall->get_floors_with_vacancies();

        #test($floors, 1);

        if(!$floors){
            // throw an error
        }
       
        $xml_floors = array();
        
        foreach ($floors as $floor){
            $xml_floors[] = array('id' => $floor->id, 'floor_num' => $floor->floor_number);
        }
        
        $serializer_options = array (
            'addDecl' => TRUE,
            'encoding' => 'UTF-8',
            'indent' => '',
            'rootName' => 'floors',
            'defaultTagName' => 'floor');

        $serializer = new XML_Serializer($serializer_options);

        $status = $serializer->serialize($xml_floors);

        if(PEAR::isError($status)){
            die($status->getMessage());
        }

        header('Content-type: text/xml');
        echo $serializer->getSerializedData();
        exit;
    }

    function getRooms($floor_id){
       
        PHPWS_Core::initModClass('hms', 'HMS_Floor.php');
        
        $floor = &new HMS_Floor($floor_id);

        $rooms = $floor->get_rooms();

        if(!$rooms){
            // throw an error
        }

        $xml_rooms = array();

        foreach($rooms as $room){
            $xml_rooms[] = array('id' => $room->id, 'room_num' => $room->room_number);
        }

        $serializer_options = array (
            'addDecl' => TRUE,
            'encoding' => 'ISO-8859-1',
            'indent' => '  ',
            'rootName' => 'rooms',
            'defaultTagName' => 'room',);

        $serializer = &new XML_Serializer($serializer_options);

        $status = $serializer->serialize($xml_rooms);

        if(PEAR::isError($status)){
            die($status->getMessage());
        }

        header('Content-type: text/xml');
        echo $serializer->getSerializedData();
        exit;
    }

    function getRoomsWithVacancies($floor_id){
        PHPWS_Core::initModClass('hms', 'HMS_Floor.php');

        $floor = &new HMS_Floor($floor_id);

        $rooms = $floor->get_rooms_with_vacancies();

        #test($floors, 1);

        if(!$rooms){
            // throw an error
        }
       
        $xml_rooms = array();
        
        foreach ($rooms as $room){
            $xml_rooms[] = array('id' => $room->id, 'room_num' => $room->room_number);
        }
        
        $serializer_options = array (
            'addDecl' => TRUE,
            'encoding' => 'UTF-8',
            'indent' => '',
            'rootName' => 'rooms',
            'defaultTagName' => 'room');

        $serializer = new XML_Serializer($serializer_options);

        $status = $serializer->serialize($xml_rooms);

        if(PEAR::isError($status)){
            die($status->getMessage());
        }

        header('Content-type: text/xml');
        echo $serializer->getSerializedData();
        exit;

    }

    function getBedroomsWithVacancies($room_id){
        PHPWS_Core::initModClass('hms', 'HMS_Room.php');

        $room = &new HMS_Room($room_id);
        
        $bedrooms = $room->get_bedrooms_with_vacancies();

        #test($bedrooms, 1);

        if(!$bedrooms){
            // throw an error
            die("Could not load bedrooms");
        }
       
        $xml_bedrooms = array();
        
        foreach ($bedrooms as $bedroom){
            $xml_bedrooms[] = array('id' => $bedroom->id, 'bedroom_letter' => $bedroom->bedroom_letter);
        }
        
        $serializer_options = array (
            'addDecl' => TRUE,
            'encoding' => 'UTF-8',
            'indent' => '',
            'rootName' => 'bedrooms',
            'defaultTagName' => 'bedroom');

        $serializer = new XML_Serializer($serializer_options);

        $status = $serializer->serialize($xml_bedrooms);

        if(PEAR::isError($status)){
            die($status->getMessage());
        }

        header('Content-type: text/xml');
        echo $serializer->getSerializedData();
        exit;

    }

    function getBedsWithVacancies($bedroom_id){
        PHPWS_Core::initModClass('hms', 'HMS_Bedroom.php');

        $bedroom = &new HMS_Bedroom($bedroom_id);
        
        $beds = $bedroom->get_beds_with_vacancies();

        #test($bedrooms, 1);

        if(!$beds){
            // throw an error
            die("Could not load beds");
        }
       
        $xml_beds = array();
        
        foreach ($beds as $bed){
            $xml_beds[] = array('id' => $bed->id, 'bed_letter' => $bed->bed_letter);
        }
        
        $serializer_options = array (
            'addDecl' => TRUE,
            'encoding' => 'UTF-8',
            'indent' => '',
            'rootName' => 'beds',
            'defaultTagName' => 'bed');

        $serializer = new XML_Serializer($serializer_options);

        $status = $serializer->serialize($xml_beds);

        if(PEAR::isError($status)){
            die($status->getMessage());
        }

        header('Content-type: text/xml');
        echo $serializer->getSerializedData();
        exit;

    }

}

?>
