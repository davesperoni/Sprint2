<?php

/**
 * Test
 * Created by PhpStorm.
 * User: ViviannRutan
 * Date: 3/23/17
 * Time: 12:04 PM
 */
class EmergencyContact
{
    public function __construct($EmergencyFirstName, $EmergencyMiddleInitial, $EmergencyLastName, $EmergencyPhoneNumber, $EmergencyRelationship)
    {
        $this->firstName = $EmergencyFirstName;
        $this->middleInitial = $EmergencyMiddleInitial;
        $this->lastName = $EmergencyLastName;
        $this->phoneNumber = $EmergencyPhoneNumber;
        $this->relationship = $EmergencyRelationship;
        $this->lastUpdatedBy = "System";
        $this->lastUpdated = "CURRENT_TIMESTAMP";
    }

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getEmergencyFirstName()
    {

        return $this->firstName;

    }

    public function getEmergencyLastName()
    {

        return $this->lastName;

    }

    public function getEmergencyMiddleInitial()
    {

        return $this->middleInitial;

    }

    public function getEmergencyRelationship()
    {

        return $this->relationship;

    }

    public function getEmergencyPhoneNumber()
    {

        return $this->phoneNumber;

    }

    public function getEmergencyLastUpdated()
    {

        return $this->lastUpdated;

    }

    public function getEmergencyLastUpdatedBy()
    {

        return $this->lastUpdatedBy;

    }
}