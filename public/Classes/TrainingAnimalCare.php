<?php

/**
 * Created by PhpStorm.
 * User: ShanikaWije
 * Date: 4/16/2017
 * Time: 1:26 PM
 */
class TrainingAnimalCare
{
    public function __construct($volunteerID, $departmentID, $reptileRoom, $reptileSoak, $snakeFeed,
                                $ICU, $expandedICU, $aviary, $mammals, $pue, $pueWeighDay, $fawns,
                                $formula, $meals, $raptorFeed, $iso, $notes)
    {
        $this->departmentID = $departmentID;
        $this->volunteerID = $volunteerID;
        $this->reptileRoom = $reptileRoom;
        $this->reptileSoak = $reptileSoak;
        $this->snakeFeed = $snakeFeed;
        $this->ICU = $ICU;
        $this->expandedICU = $expandedICU;
        $this->aviary = $aviary;
        $this->mammals = $mammals;
        $this->pue = $pue;
        $this->pueWeighDay = $pueWeighDay;
        $this->fawns = $fawns;
        $this->formula = $formula;
        $this->meals = $meals;
        $this->raptorFeed = $raptorFeed;
        $this->iso = $iso;
        $this->notes = $notes;

        $this->trainingLastUpdatedBy = "System";
        $this->trainingLastUpdated = "CURRENT_TIMESTAMP";

    }

    public function getAnimalCareTrainingVolunteerID()
    {
        return $this->volunteerID;
    }
    public function getAnimalCareTrainingDepartmentID()
    {
        return $this->departmentID;
    }

    public function getTrainingReptileRoom()
    {
        return $this->reptileRoom;
    }

    public function getTrainingReptileSoak()
    {
        return $this->reptileSoak;
    }

    public function getTrainingSnakeFeed()
    {
        return $this->snakeFeed;
    }

    public function getTrainingICU()
    {
        return $this->ICU;
    }

    public function getTrainingExpandedICU()
    {
        return $this->expandedICU;
    }
    public function getTrainingAviary()
    {
        return $this->aviary;
    }

    public function getTrainingMammals()
    {
        return $this->mammals;
    }

    public function getTrainingPUE()
    {
        return $this->pue;
    }

    public function getTrainingPueWeighDay()
    {
        return $this->pueWeighDay;
    }

    public function getTrainingFawns()
    {
        return $this->fawns;
    }

    public function getTrainingFormula()
    {
        return $this->formula;
    }
    public function getTrainingMeals()
    {
        return $this->meals;
    }

    public function getTrainingRaptorFeed()
    {
        return $this->raptorFeed;
    }

    public function getTrainingISO()
    {
        return $this->iso;
    }
    public function getAnimalCareTrainingNotes()
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