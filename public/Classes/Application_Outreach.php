<?php

/**
 * Created by PhpStorm.
 * User: mandelja
 * Date: 3/23/2017
 * Time: 5:22 PM
 */
class Application_Outreach
{
    public function __construct($ApplicantExplainInterest, $ApplicantPassionateIssue,
                                $ApplicantPublicSpeakingExperience, $ApplicantAnimalRightsGroups,
                                $ApplicantYourContribution)
    {
        $this->explainInterest = $ApplicantExplainInterest;
        $this->passionateIssue = $ApplicantPassionateIssue;
        $this->publicSpeakingExperience = $ApplicantPublicSpeakingExperience;
        $this->animalRightsGroups = $ApplicantAnimalRightsGroups;
        $this->yourContribution = $ApplicantYourContribution;
        $this->lastUpdatedBy = "System";
        $this->lastUpdated = "CURRENT_TIMESTAMP";
    }

    public function getApplicantExplainInterest()
    {
        return $this->explainInterest;
    }

    public function getApplicantPassionateIssue()
    {
        return $this->passionateIssue;
    }

    public function getApplicantPublicSpeakingExperience()
    {
        return $this->publicSpeakingExperience;
    }

    public function getApplicantAnimalRightsGroups()
    {
        return $this->animalRightsGroups;
    }

    public function getApplicantYourContribution()
    {
        return $this->yourContribution;
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