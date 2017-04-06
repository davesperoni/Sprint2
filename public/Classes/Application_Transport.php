<?php

/**
 * Created by PhpStorm.
 * User: mandelja
 * Date: 3/23/2017
 * Time: 5:28 PM
 */
class Application_Transport
{
    public function __construct($ApplicantCaptureAndRestraint, $ApplicantMilesWillingToTravel, $ApplicantSpeciesLimitations)
    {
        $this->captureAndRestraint = $ApplicantCaptureAndRestraint;
        $this->milesWillingToTravel = $ApplicantMilesWillingToTravel;
        $this->speciesLimitations = $ApplicantSpeciesLimitations;
        $this->lastUpdatedBy = "System";
        $this->lastUpdated = "CURRENT_TIMESTAMP";
    }

    public function getApplicantCaptureAndRestraint()
    {
        return $this->captureAndRestraint;
    }

    public function getApplicantMilesWillingToTravel()
    {
        return $this->milesWillingToTravel;
    }

    public function getApplicantSpeciesLimitations()
    {
        return $this->speciesLimitations;
    }

    public function getApplicantLastUpdated()
    {
        return $this->lastUpdated;
    }

    public function getApplicantLastUpdatedBy()
    {
        return $this->lastUpdatedBy;
    }

}
