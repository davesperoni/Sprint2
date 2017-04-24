<?php

/**
 * Created by PhpStorm.
 * User: ShanikaWije
 * Date: 4/15/2017
 * Time: 9:31 PM
 */
class TrainingOutreach
{
    public function __construct($volunteerID, $departmentID, $shadowTourCount, $introTraining, $leadTourAlone, $offSiteDisplay, $notes)
    {
        $this->departmentID = $departmentID;
        $this->volunteerID = $volunteerID;
        $this->shadowTourCount = $shadowTourCount;
        $this->introTraining = $introTraining;
        $this->leadTourAlone = $leadTourAlone;
        $this->offSiteDisplay = $offSiteDisplay;
        $this->notes = $notes;

        $this->trainingLastUpdatedBy = "System";
        $this->trainingLastUpdated = "CURRENT_TIMESTAMP";

    }

    public function getOutreachTrainingVolunteerID()
    {
        return $this->volunteerID;
    }
    public function getOutreachTrainingDepartmentID()
    {
        return $this->departmentID;
    }

    public function getTrainingShadowTourCount()
    {
        return $this->shadowTourCount;
    }

    public function getTrainingIntroTraining()
    {
        return $this->introTraining;
    }

    public function getTrainingLeadTourAlone()
    {
        return $this->leadTourAlone;
    }

    public function getTrainingOffSiteDisplay()
    {
        return $this->offSiteDisplay;
    }

    public function getOutreachTrainingNotes()
    {
        return $this->notes;
    }

    public function getTrainingLastUpdatedBy()
    {
        return $this->trainingLastUpdatedBy;
    }

    public function getTrainingLastUpdated()
    {
        return $this->trainingLastUpdated;
    }

}