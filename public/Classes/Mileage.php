<?php

/**
 * Created by PhpStorm.
 * User: ShanikaWije
 * Date: 4/8/2017
 * Time: 1:06 AM
 */
class Mileage
{
    public function __construct($DepartmentID, $VolunteerID, $TripDate, $TripMiles, $TripStreet, $TripCity, $TripStateAbb, $TripCounty, $TripZipCode, $AnimalTransported)
    {
        $this->departmentID = $DepartmentID;
        $this->volunteerID = $VolunteerID;
        $this->tripDate = $TripDate;
        $this->tripMiles = $TripMiles;
        $this->tripStreet = $TripStreet;
        $this->tripCity = $TripCity;
        $this->tripStateAbb = $TripStateAbb;
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
    public function getMileageTripStateAbb()
    {

        return $this->tripStateAbb;
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