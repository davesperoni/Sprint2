<?php

/**
 * Created by PhpStorm.
 * User: ShanikaWije
 * Date: 4/16/2017
 * Time: 3:50 PM
 */
class TrainingTransport
{
    public function __construct($volunteerID, $departmentID, $captureAndResistance, $distance, $speciesLimits, $notes)
    {
        $this->departmentID = $departmentID;
        $this->volunteerID = $volunteerID;
        $this->captureAndResistance = $captureAndResistance;
        $this->distance = $distance;
        $this->speciesLimits = $speciesLimits;
        $this->notes = $notes;

        $this->trainingLastUpdatedBy = "System";
        $this->trainingLastUpdated = "CURRENT_TIMESTAMP";

    }

    public function getTransportTrainingVolunteerID()
    {
        return $this->volunteerID;
    }
    public function getTransportTrainingDepartmentID()
    {
        return $this->departmentID;
    }

    public function getTrainingCaptureAndResistance()
    {
        return $this->captureAndResistance;
    }

    public function getTrainingDistance()
    {
        return $this->distance;
    }

    public function getTrainingSpeciesLimits()
    {
        return $this->speciesLimits;
    }

    public function getTransportTrainingNotes()
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