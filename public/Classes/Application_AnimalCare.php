<?php

/**
 * Created by PhpStorm.
 * User: mandelja
 * Date: 3/23/2017
 * Time: 5:27 PM
 */
class Application_AnimalCare
{
    public function __construct($ApplicantReptileRoom, $ApplicantReptileRoomSoakDay, $ApplicantSnakeFeeding,
                                $ApplicantICU, $ApplicantICUExpanded, $ApplicantAviary,
                                $ApplicantMammals, $ApplicantPUE, $ApplicantPUEWeighDay, $ApplicantFawns,
                                $ApplicantFormula, $ApplicantMeals, $ApplicantRaptorFeed, $ApplicantISO,
                                $ApplicantPreviousExperience, $ApplicantDeadAnimalHandling, $ApplicantLivePreyOpinion,
                                $ApplicantOutdoorWork, $ApplicantAnimalRightsGroups, $ApplicantGoals,
                                $ApplicantPassionateIssue)
    {
        $this->reptileRoom = $ApplicantReptileRoom;
        $this->reptileRoomSoakDay =$ApplicantReptileRoomSoakDay;
        $this->snakeFeeding = $ApplicantSnakeFeeding;
        $this->ICU = $ApplicantICU;
        $this->ICUExpanded = $ApplicantICUExpanded;
        $this->aviary = $ApplicantAviary;
        $this->mammals = $ApplicantMammals;
        $this->PUE = $ApplicantPUE;
        $this->PUEWeighDay = $ApplicantPUEWeighDay;
        $this->fawns = $ApplicantFawns;
        $this->formula = $ApplicantFormula;
        $this->meals = $ApplicantMeals;
        $this->raptorFeed = $ApplicantRaptorFeed;
        $this->ISO = $ApplicantISO;
        $this->previousExperience = $ApplicantPreviousExperience;
        $this->deadAnimalHandling = $ApplicantDeadAnimalHandling;
        $this->livePreyOpinion = $ApplicantLivePreyOpinion;
        $this->outdoorWork = $ApplicantOutdoorWork;
        $this->animalRightsGroups = $ApplicantAnimalRightsGroups;
        $this->goals = $ApplicantGoals;
        $this->passionateIssue = $ApplicantPassionateIssue;
        $this->lastUpdatedBy = "System";
        $this->lastUpdated = "CURRENT_TIMESTAMP";
    }

    public function getApplicantReptileRoom()
    {
        return $this->reptileRoom;
    }

    public function getApplicantReptileRoomSoakDay()
    {
        return $this->reptileRoomSoakDay;
    }

    public function getApplicantSnakeFeeding()
    {
        return $this->snakeFeeding;
    }

    public function getApplicantICU()
    {
        return $this->ICU;
    }

    public function getApplicantICUExpanded()
    {
        return $this->ICUExpanded;
    }

    public function getApplicantAviary()
    {
        return $this->aviary;
    }

    public function getApplicantMammals()
    {
        return $this->mammals;
    }

    public function getApplicantPUE()
    {
        return $this->PUE;
    }

    public function getApplicantPUEWeighDay()
    {
        return $this->PUEWeighDay;
    }

    public function getApplicantFawns()
    {
        return $this->fawns;
    }

    public function getApplicantFormula()
    {
        return $this->formula;
    }

    public function getApplicantMeals()
    {
        return $this->meals;
    }

    public function getApplicantRaptorFeed()
    {
        return $this->raptorFeed;
    }

    public function getApplicantISO()
    {
        return $this->ISO;
    }

    public function getApplicantPreviousExperience()
    {
        return $this->previousExperience;
    }

    public function getApplicantDeadAnimalHandling()
    {
        return $this->deadAnimalHandling;
    }

    public function getApplicantLivePreyOpinion()
    {
        return $this->livePreyOpinion;
    }

    public function getApplicantOutdoorWork()
    {
        return $this->outdoorWork;
    }

    public function getApplicantAnimalRightsGroups()
    {
        return $this->animalRightsGroups;
    }

    public function getApplicantGoals()
    {
        return $this->goals;
    }

    public function getApplicantPassionateIssue()
    {
        return $this->passionateIssue;
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
