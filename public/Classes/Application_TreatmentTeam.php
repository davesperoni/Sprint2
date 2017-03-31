<?php

/**
 * Created by PhpStorm.
 * User: mandelja
 * Date: 3/23/2017
 * Time: 5:27 PM
 */
class Application_TreatmentTeam
{
    public function __construct($ApplicantHandleSmallMammals, $ApplicantHandleLargeMammals, $ApplicantHandleRVS,
                                $ApplicantHandleEagles, $ApplicantHandleSmallRaptors, $ApplicantHandleLargeRaptors,
                                $ApplicantHandleReptiles, $ApplicantDescribeAnimalTraining, $ApplicantTrainingVet,
                                $ApplicantTrainingTech, $ApplicantDescribeMedicalTraining, $ApplicantPatientMedicate,
                                $ApplicantPatientBandage, $ApplicantPatientWoundCare, $ApplicantPatientDiagnostics,
                                $ApplicantPatientAnesthesia, $ApplicantDescribePatientSkills, $ApplicantBestWorkEnvironment,
                                $ApplicantBestLearningMethod, $ApplicantEuthanasiaExperience, $ApplicantMessyRequirements)
    {

        $this->handleSmallMammals = $ApplicantHandleSmallMammals;
        $this->handleLargeMammals = $ApplicantHandleLargeMammals;
        $this->handleRVS = $ApplicantHandleRVS;
        $this->handleEagles = $ApplicantHandleEagles;
        $this->handleSmallRaptors = $ApplicantHandleSmallRaptors;
        $this->handleLargeRaptors = $ApplicantHandleLargeRaptors;
        $this->handleReptiles = $ApplicantHandleReptiles;
        $this->describeAnimalTraining = $ApplicantDescribeAnimalTraining;
        $this->trainingVet = $ApplicantTrainingVet;
        $this->trainingTech = $ApplicantTrainingTech;
        $this->describeMedicalTraining = $ApplicantDescribeMedicalTraining;
        $this->patientMedicate = $ApplicantPatientMedicate;
        $this->patientBandage = $ApplicantPatientBandage;
        $this->patientWoundCare = $ApplicantPatientWoundCare;
        $this->patientDiagnostics = $ApplicantPatientDiagnostics;
        $this->patientAnesthesia = $ApplicantPatientAnesthesia;
        $this->describePatientSkills = $ApplicantDescribePatientSkills;
        $this->bestWorkEnvironment = $ApplicantBestWorkEnvironment;
        $this->bestLearningMethod = $ApplicantBestLearningMethod;
        $this->euthanasiaExperience = $ApplicantEuthanasiaExperience;
        $this->messyRequirements = $ApplicantMessyRequirements;
        $this->lastUpdatedBy = "System";
        $this->lastUpdated = "CURRENT_TIMESTAMP";
    }

    public function getApplicantHandleSmallMammals()
    {
        return $this->handleSmallMammals;
    }

    public function getApplicantHandleLargeMammals()
    {
        return $this->handleLargeMammals;
    }

    public function getApplicantHandleRVS()
    {
        return $this->handleRVS;
    }

    public function getApplicantHandleEagles()
    {
        return $this->handleEagles;
    }

    public function getApplicantHandleSmallRaptors()
    {
        return $this->handleSmallRaptors;
    }

    public function getApplicantHandleLargeRaptors()
    {
        return $this->handleLargeRaptors;
    }

    public function getApplicantHandleReptiles()
    {
        return $this->handleReptiles;
    }

    public function getApplicantDescribeAnimalTraining()
    {
        return $this->describeAnimalTraining;
    }

    public function getApplicantTrainingVet()
    {
        return $this->trainingVet;
    }

    public function getApplicantTrainingTech()
    {
        return $this->trainingTech;
    }

    public function getApplicantDescribeMedicalTraining()
    {
        return $this->describeMedicalTraining;
    }

    public function getApplicantPatientMedicate()
    {
        return $this->patientMedicate;
    }

    public function getApplicantPatientBandage()
    {
        return $this->patientBandage;
    }

    public function getApplicantPatientWoundCare()
    {
        return $this->patientWoundCare;
    }

    public function getApplicantPatientDiagnostics()
    {
        return $this->patientDiagnostics;
    }

    public function getApplicantPatientAnesthesia()
    {
        return $this->patientAnesthesia;
    }

    public function getApplicantDescribePatientSkills()
    {
        return $this->describePatientSkills;
    }

    public function getApplicantBestWorkEnvironment()
    {
        return $this->bestWorkEnvironment;
    }

    public function getApplicantBestLearningMethod()
    {
        return $this->bestLearningMethod;
    }

    public function getApplicantEuthanasiaExperience()
    {
        return $this->euthanasiaExperience;
    }

    public function getApplicantMessyRequirements()
    {
        return $this->messyRequirements;
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