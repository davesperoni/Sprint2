<?php

/**
 * Created by PhpStorm.
 * User: ViviannRutan
 * Date: 4/1/17
 * Time: 12:31 PM
 */
class Shift
{
    public function __construct($VolunteerID, $ShiftDate, $StartTime, $EndTime, $ShiftHours)
    {
        $this->volunteerID = $VolunteerID;
        $this->shiftDate = $ShiftDate;
        $this->startTime = $StartTime;
        $this->endTime = $EndTime;
        $this->shiftHours = $ShiftHours;
        $this->lastUpdatedBy = "System";
        $this->lastUpdated = "CURRENT_TIMESTAMP";
    }
    public function getShiftVolunteerID()
    {

        return $this->volunteerID;

    }

    public function getShiftDate()
    {

        return $this->shiftDate;
    }
    public function getShiftStartTime()
    {

        return $this->startTime;
    }

    public function getShiftEndTime()
    {

        return $this->endTime;

    }

    public function getShiftHours()
    {

        return $this->shiftHours;

    }
    public function getShiftLastUpdated()
    {

        return $this->lastUpdated;

    }

    public function getShiftLastUpdatedBy()
    {

        return $this->lastUpdatedBy;

    }
}