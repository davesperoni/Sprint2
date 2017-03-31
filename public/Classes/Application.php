<?php

/**
 * Test
 * Created by PhpStorm.
 * User: ViviannRutan
 * Date: 3/22/17
 * Time: 10:43 PM
 */
class Application
{
    public function __construct($personID, $applicationStatus, $applicationDepartmentID, $carpentrySkills, $frontDeskTrained, $adminAssistant)
    {

        $this->applicationPersonID = $personID;
        $this->applicationStatus = $applicationStatus;
        $this->applicationDepartmentID = $applicationDepartmentID;
        $this->applicationCarpentrySkills = $carpentrySkills;
        $this->applicationFrontDeskTrained = $frontDeskTrained;
        $this->applicationAdminAssistant = $adminAssistant;

        $this->applicationLastUpdatedBy = "System";
        $this->applicationLastUpdated = "CURRENT_TIMESTAMP";

    }

    public function getApplicationPersonID()
    {
        return $this->applicationPersonID;
    }

    public function getApplicationStatus()
    {
        return $this->applicationStatus;
    }

    public function getApplicationDepartmentID()
    {
        return $this->applicationDepartmentID;
    }

    public function getApplicationCarpentrySkills()
    {
        return $this->applicationCarpentrySkills;
    }

    public function getApplicationFrontDeskTrained()
    {
        return $this->applicationFrontDeskTrained;
    }

    public function getApplicationAdminAssistant()
    {
        return $this->applicationAdminAssistant;
    }

    public function getApplicationIsStudent()
    {
        return $this->isStudent;
    }

    public function getApplicationLastUpdatedBy()
    {
        return $this->applicationLastUpdatedBy;
    }

    public function getApplicationLastUpdated()
    {
        return $this->applicationLastUpdated;
    }

}