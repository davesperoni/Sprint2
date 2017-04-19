<?php

/**
 * Created by PhpStorm.
 * User: ShanikaWije
 * Date: 4/16/2017
 * Time: 12:08 AM
 */
class TrainingTreatment
{
    public function __construct($volunteerID, $departmentID, $smallMammals, $largeMammals, $RVS, $eagles,
                                $smallRaptors, $largeRaptors, $reptiles, $vet, $technician, $vetStudent,
                                $techStudent, $vetAssistant, $medicating, $bandaging, $woundCare,
                                $diagnostics, $anesthesia, $notes)
    {
        $this->departmentID = $departmentID;
        $this->volunteerID = $volunteerID;
        $this->smallMammals = $smallMammals;
        $this->largeMammals = $largeMammals;
        $this->RVS = $RVS;
        $this->eagles = $eagles;
        $this->smallRaptors = $smallRaptors;
        $this->largeRaptors = $largeRaptors;
        $this->reptiles = $reptiles;
        $this->vet = $vet;
        $this->technician = $technician;
        $this->vetStudent = $vetStudent;
        $this->techStudent = $techStudent;
        $this->vetAssistant = $vetAssistant;
        $this->medicating = $medicating;
        $this->bandaging = $bandaging;
        $this->woundCare = $woundCare;
        $this->diagnostics = $diagnostics;
        $this->anesthesia = $anesthesia;
        $this->notes = $notes;


        $this->trainingLastUpdatedBy = "System";
        $this->trainingLastUpdated = "CURRENT_TIMESTAMP";

    }

    public function getTreatmentTrainingVolunteerID()
    {
        return $this->volunteerID;
    }
    public function getTreatmentTrainingDepartmentID()
    {
        return $this->departmentID;
    }

    public function getTrainingSmallMammals()
    {
        return $this->smallMammals;
    }

    public function getTrainingLargeMammals()
    {
        return $this->largeMammals;
    }

    public function getTrainingRVS()
    {
        return $this->RVS;
    }

    public function getTrainingEagles()
    {
        return $this->eagles;
    }

    public function getTrainingSmallRaptors()
    {
        return $this->smallRaptors;
    }
    public function getTrainingLargeRaptors()
    {
        return $this->largeRaptors;
    }

    public function getTrainingReptiles()
    {
        return $this->reptiles;
    }

    public function getTrainingVet()
    {
        return $this->vet;
    }

    public function getTrainingTechnician()
    {
        return $this->technician;
    }

    public function getTrainingVetStudent()
    {
        return $this->vetStudent;
    }

    public function getTrainingTechStudent()
    {
        return $this->techStudent;
    }

    public function getTrainingVetAssistant()
    {
        return $this->vetAssistant;
    }
    public function getTrainingMedicating()
    {
        return $this->medicating;
    }

    public function getTrainingBandaging()
    {
        return $this->bandaging;
    }
    public function getTrainingWoundCare()
    {
        return $this->woundCare;
    }
    public function getTrainingDiagnostics()
    {
        return $this->diagnostics;
    }

    public function getTrainingAnesthesia()
    {
        return $this->anesthesia;
    }
    public function getTreatmentTrainingNotes()
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