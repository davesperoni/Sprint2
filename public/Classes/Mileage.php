<?php

/**
 * Created by PhpStorm.
 * User: ShanikaWije
 * Date: 4/11/2017
 * Time: 3:00 AM
 */
class Mileage
{
    public function __construct($DepartmentID, $VolunteerID, $TripDate, $TripMiles, $TripStreet, $TripCity, $TripState, $TripCounty, $TripZipCode, $AnimalTransported)
    {
        $this->departmentID = $DepartmentID;
        $this->volunteerID = $VolunteerID;
        $this->tripDate = $TripDate;
        $this->tripMiles = $TripMiles;
        $this->tripStreet = $TripStreet;
        $this->tripCity = $TripCity;
        $this->tripState = $TripState;
        $this->tripCounty = $TripCounty;
        $this->tripZipCode = $TripZipCode;
        $this->animalTransported = $AnimalTransported;
        $this->lastUpdatedBy = "System";
        $this->lastUpdated = "CURRENT_TIMESTAMP";
    }
    public function getMileageVolunteerID()
    {

        return $this->volunteerID;

    }
    public function getMileageDepartmentID()
    {

        return $this->departmentID;

    }

    public function getMileageTripDate()
    {

        return $this->tripDate;
    }
    public function getMileageTripMiles()
    {

        return $this->tripMiles;
    }
    public function getMileageTripStreet()
    {

        return $this->tripStreet;
    }
    public function getMileageTripCity()
    {

        return $this->tripCity;
    }
    public function getMileageTripState()
    {

        return $this->tripState;
    }
    public function getMileageTripCounty()
    {

        return $this->tripCounty;
    }
    public function getMileageTripZipCode()
    {

        return $this->tripZipCode;
    }
    public function getMileageAnimalTransported()
    {

        return $this->animalTransported;
    }

    public function getMileageLastUpdated()
    {

        return $this->lastUpdated;

    }

    public function getMileageLastUpdatedBy()
    {

        return $this->lastUpdatedBy;

    }

}