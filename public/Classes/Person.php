<?php

/**
 * Test
 * Created by PhpStorm.
 * User: Drew
 * Date: 3/22/17
 * Time: 10:05 PM
 * Test
 */
class Person
{
    public function __construct($EmergencyContactID, $PersonAccountID, $PersonFirstName, $PersonMiddleInitial, $PersonLastName, $PersonStreetAddress, $PersonCity, $PersonCounty, $PersonState, $PersonCountry, $PersonZipCode, $PersonPhoneNumber, $PersonDateOfBirth, $PersonAllergy, $PersonPhysicalLimitation, $PersonHavePermit, $PersonPermitType, $PersonRabies)
    {
        $this->emergencyContactID = $EmergencyContactID;
        $this->accountID = $PersonAccountID;
        $this->firstName = $PersonFirstName;
        $this->middleInitial = $PersonMiddleInitial;
        $this->lastName = $PersonLastName;
        $this->streetAddress = $PersonStreetAddress;
        $this->city = $PersonCity;
        $this->county = $PersonCounty;
        $this->stateAbb = $PersonState;
        $this->countryAbb = $PersonCountry;
        $this->zipCode = $PersonZipCode;
        $this->phoneNumber = $PersonPhoneNumber;
        $this->dateOfBirth = $PersonDateOfBirth;
        $this->allergy = $PersonAllergy;
        $this->physicalLimitation = $PersonPhysicalLimitation;
        $this->havePermit = $PersonHavePermit;
        $this->permitType = $PersonPermitType;
        $this->rabiesVaccine = $PersonRabies;
        //$this->notes = $PersonNotes;
        $this->lastUpdatedBy = "System";
        $this->lastUpdated = "CURRENT_TIMESTAMP";
    }

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getEmergencyContactID()
    {

        return $this->emergencyContactID;

    }

    public function getPersonAccountID()
    {

        return $this->accountID;

    }

    public function getPersonFirstName()
    {

        return $this->firstName;

    }

    public function getPersonLastName()
    {

        return $this->lastName;

    }

    public function getPersonMiddleInitial()
    {

        return $this->middleInitial;

    }

    public function getPersonStreetAddress()
    {

        return $this->streetAddress;

    }

    public function getPersonCity()
    {

        return $this->city;

    }

    public function getPersonCounty()
    {

        return $this->county;

    }

    public function getPersonState()
    {

        return $this->state;

    }

    public function getPersonCountry()
    {

        return $this->country;

    }
    public function getPersonZipCode()
    {

        return $this->zipCode;

    }

    public function getPersonPhoneNumber()
    {

        return $this->phoneNumber;

    }

    public function getPersonDateOfBirth()
    {

        return $this->dateOfBirth;

    }

    public function getPersonAllergy()
    {

        return $this->allergy;

    }

    public function getPersonPhysicalLimitation()
    {

        return $this->physicalLimitation;

    }

    public function getPersonHavePermit()
    {

        return $this->havePermit;

    }

    public function getPersonPermitType()
    {

        return $this->permitType;

    }

    public function getPersonRabiesVaccine()
    {

        return $this->rabiesVaccine;

    }

//    public function getPersonNotes()
//    {
//
//        return $this->notes;
//
//    }

    public function getPersonLastUpdated()
    {

        return $this->lastUpdated;

    }

    public function getPersonLastUpdatedBy()
    {

        return $this->lastUpdatedBy;

    }

}

