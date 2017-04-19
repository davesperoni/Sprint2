<?php include("Classes/TrainingOutreach.php"); ?>
<?php include("Classes/TrainingTreatment.php"); ?>
<?php include("Classes/TrainingAnimalCare.php"); ?>
<?php include("Classes/TrainingTransport.php"); ?>
<?php
/**
 * Created by PhpStorm.
 * User: ShanikaWije
 * Date: 4/15/2017
 * Time: 9:05 PM
 */
session_start();

require 'databasePDO.php';
require 'database.php';

$PersonID = $_GET['id'];
$records = $connPDO->prepare('select FirstName, MiddleInitial, LastName FROM Person where PersonID = :PersonID');
$records->bindParam(':PersonID', $PersonID);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);

if(count($results) > 0){
    $personInformation = $results;
}

$volunteerName = $personInformation['FirstName'] . " " . $personInformation['MiddleInitial'] . " " . $personInformation['LastName'];

// ANIMAL CARE

$isAnimalCareVolunteer = 'no';

$records = $connPDO->prepare('SELECT VolunteerDepartment.VolunteerID FROM VolunteerDepartment 
JOIN Volunteer ON VolunteerDepartment.VolunteerID = Volunteer.VolunteerID 
JOIN Person ON Volunteer.PersonID = Person.PersonID
WHERE VolunteerDepartment.DepartmentID = 1 AND Person.PersonID = :PersonID');
$records->bindParam(':PersonID', $PersonID);
$records->execute();
$IsAnimalCareResults = $records->fetch(PDO::FETCH_ASSOC);

if ($IsAnimalCareResults != null) {
    $isAnimalCareVolunteer = 'yes';
}

$isVolunteerDeptAnimalCare = 'no';

$records = $connPDO->prepare('SELECT VolunteerDepartmentAnimalCare.VolunteerID FROM VolunteerDepartmentAnimalCare 
JOIN VolunteerDepartment ON VolunteerDepartment.VolunteerID = VolunteerDepartmentAnimalCare.VolunteerID
JOIN Volunteer ON VolunteerDepartment.VolunteerID = Volunteer.VolunteerID 
JOIN Person ON Volunteer.PersonID = Person.PersonID
WHERE VolunteerDepartment.DepartmentID = 1 AND Person.PersonID = :PersonID');
$records->bindParam(':PersonID', $PersonID);
$records->execute();
$IsDeptAnimalCare = $records->fetch(PDO::FETCH_ASSOC);

if ($IsDeptAnimalCare != null) {
    $isVolunteerDeptAnimalCare = 'yes';
}


// OUTREACH

$isOutreachVolunteer = 'no';

$records = $connPDO->prepare('SELECT VolunteerDepartment.VolunteerID FROM VolunteerDepartment 
JOIN Volunteer ON VolunteerDepartment.VolunteerID = Volunteer.VolunteerID 
JOIN Person ON Volunteer.PersonID = Person.PersonID
WHERE VolunteerDepartment.DepartmentID = 2 AND Person.PersonID = :PersonID');
$records->bindParam(':PersonID', $PersonID);
$records->execute();
$IsOutreachResults = $records->fetch(PDO::FETCH_ASSOC);

if ($IsOutreachResults != null) {
    $isOutreachVolunteer = 'yes';
}

$isVolunteerDeptOutreach = 'no';

$records = $connPDO->prepare('SELECT VolunteerDepartmentOutreach.VolunteerID FROM VolunteerDepartmentOutreach 
JOIN VolunteerDepartment ON VolunteerDepartment.VolunteerID = VolunteerDepartmentOutreach.VolunteerID
JOIN Volunteer ON VolunteerDepartment.VolunteerID = Volunteer.VolunteerID 
JOIN Person ON Volunteer.PersonID = Person.PersonID
WHERE VolunteerDepartment.DepartmentID = 2 AND Person.PersonID = :PersonID');
$records->bindParam(':PersonID', $PersonID);
$records->execute();
$IsDeptOutreach = $records->fetch(PDO::FETCH_ASSOC);

if ($IsDeptOutreach != null) {
    $isVolunteerDeptOutreach = 'yes';
}


// TRANSPORT

$isTransportVolunteer = 'no';

$records = $connPDO->prepare('SELECT VolunteerDepartment.VolunteerID FROM VolunteerDepartment 
JOIN Volunteer ON VolunteerDepartment.VolunteerID = Volunteer.VolunteerID 
JOIN Person ON Volunteer.PersonID = Person.PersonID
WHERE VolunteerDepartment.DepartmentID = 3 AND Person.PersonID = :PersonID');
$records->bindParam(':PersonID', $PersonID);
$records->execute();
$IsTransportResults = $records->fetch(PDO::FETCH_ASSOC);

if ($IsTransportResults != null) {
    $isTransportVolunteer = 'yes';
}

$isVolunteerDeptTransport = 'no';

$records = $connPDO->prepare('SELECT VolunteerDepartmentTransport.VolunteerID FROM VolunteerDepartmentTransport 
JOIN VolunteerDepartment ON VolunteerDepartment.VolunteerID = VolunteerDepartmentTransport.VolunteerID
JOIN Volunteer ON VolunteerDepartment.VolunteerID = Volunteer.VolunteerID 
JOIN Person ON Volunteer.PersonID = Person.PersonID
WHERE VolunteerDepartment.DepartmentID = 3 AND Person.PersonID = :PersonID');
$records->bindParam(':PersonID', $PersonID);
$records->execute();
$IsDeptTransport = $records->fetch(PDO::FETCH_ASSOC);

if ($IsDeptTransport != null) {
    $isVolunteerDeptTransport = 'yes';
}


// TREATMENT

$isTreatmentVolunteer = 'no';

$records = $connPDO->prepare('SELECT VolunteerDepartment.VolunteerID FROM VolunteerDepartment 
JOIN Volunteer ON VolunteerDepartment.VolunteerID = Volunteer.VolunteerID 
JOIN Person ON Volunteer.PersonID = Person.PersonID
WHERE VolunteerDepartment.DepartmentID = 4 AND Person.PersonID = :PersonID');
$records->bindParam(':PersonID', $PersonID);
$records->execute();
$IsTreatmentResults = $records->fetch(PDO::FETCH_ASSOC);

if ($IsTreatmentResults != null) {
    $isTreatmentVolunteer = 'yes';
}

$isVolunteerDeptTreatment = 'no';

$records = $connPDO->prepare('SELECT VolunteerDepartmentTreatment.VolunteerID FROM VolunteerDepartmentTreatment 
JOIN VolunteerDepartment ON VolunteerDepartment.VolunteerID = VolunteerDepartmentTreatment.VolunteerID
JOIN Volunteer ON VolunteerDepartment.VolunteerID = Volunteer.VolunteerID 
JOIN Person ON Volunteer.PersonID = Person.PersonID
WHERE VolunteerDepartment.DepartmentID = 4 AND Person.PersonID = :PersonID');
$records->bindParam(':PersonID', $PersonID);
$records->execute();
$IsDeptTreatment = $records->fetch(PDO::FETCH_ASSOC);

if ($IsDeptTreatment != null) {
    $isVolunteerDeptTreatment = 'yes';
}

//var_dump($IsAnimalCareResults['VolunteerID'], $isAnimalCareVolunteer, $isOutreachVolunteer, $isTransportVolunteer, $isTreatmentVolunteer);


// Submit changes to a volunteer's Outreach Training

if (isset($_POST['SubmitOutreachTraining'])) {
    header("Refresh:0");
    $VolunteerID = $IsOutreachResults['VolunteerID'];
    $DepartmentID = 2;

	//var_dump($VolunteerID);
	
    $sqlDeleteOutreachTraining = "delete from VolunteerDepartmentOutreach where VolunteerID = $VolunteerID";
    $stmt = mysqli_prepare($conn, $sqlDeleteOutreachTraining);
    if ($stmt) {
        $stmt->execute();
    }

    $introTraining = 'no';
    $leadTourAlone = 'no';
    $offSiteDisplay = 'no';
    $notes = "";

    if (!empty($_POST['intro_portion'])) {
        $introTraining = 'yes';
    }
    if (!empty($_POST['lead_alone'])) {
        $leadTourAlone = 'yes';
    }
    if (!empty($_POST['offSite_displays'])) {
        $offSiteDisplay = 'yes';
    }

    $notes = $_POST['OutreachTrainingNotes'];



    $shadowTourCount = 0;

    if (!empty($_POST['shadow'])) {
        foreach ($_POST['shadow'] as $shadow) {

            $shadowTourCount++;
        }
    }
  //  var_dump($VolunteerID, $DepartmentID, $introTraining, $leadTourAlone, $offSiteDisplay, $shadowTourCount, $notes);

    $newTrainingOutreach = new TrainingOutreach($VolunteerID, $DepartmentID, $shadowTourCount, $introTraining, $leadTourAlone, $offSiteDisplay, $notes);
    $VolunteerID = $newTrainingOutreach->getOutreachTrainingVolunteerID();
    $DepartmentID = $newTrainingOutreach->getOutreachTrainingDepartmentID();
    $shadowTourCount = $newTrainingOutreach->getTrainingShadowTourCount();
    $introTraining = $newTrainingOutreach->getTrainingIntroTraining();
    $leadTourAlone = $newTrainingOutreach->getTrainingLeadTourAlone();
    $offSiteDisplay = $newTrainingOutreach->getTrainingOffSiteDisplay();
    $notes = $newTrainingOutreach->getOutreachTrainingNotes();
    $lastUpdatedBy = $newTrainingOutreach->getTrainingLastUpdatedBy();

    $sqlInsertOutreachTraining = "INSERT INTO VolunteerDepartmentOutreach (VolunteerID, DepartmentID, ShadowTourCount,IntroTraining, CanLeadTour, OffsiteDisplay, Notes, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
  //  var_dump($sqlInsertOutreachTraining);

    $stmt = mysqli_prepare($conn, $sqlInsertOutreachTraining);
    $stmt->bind_param("iiisssss", $VolunteerID, $DepartmentID, $shadowTourCount, $introTraining, $leadTourAlone, $offSiteDisplay, $notes, $lastUpdatedBy);

    if ($stmt) {
        $stmt->execute();
    }

}

// Submit changes to a volunteer's Treatment Training

if (isset($_POST['SubmitTreatmentTraining'])) {
    header("Refresh:0");
    $VolunteerID = $IsTreatmentResults['VolunteerID'];
    $DepartmentID = 4;

    $sqlDeleteTreatmentTraining = "delete from VolunteerDepartmentTreatment where VolunteerID = $VolunteerID";
    $stmt = mysqli_prepare($conn, $sqlDeleteTreatmentTraining);
    if ($stmt) {
        $stmt->execute();
    }

    // Handling Skills
    $smallMammals = 'no';
    $largeMammals = 'no';
    $rvs = 'no';
    $eagles = 'no';
    $smallRaptors = 'no';
    $largeRaptors = 'no';
    $reptiles = 'no';

    // Veterinary Skills
    $vet = 'no';
    $technician = 'no';
    $vetStudent = 'no';
    $techStudent = 'no';
    $vetAssistant = 'no';

    // Patient Care Skills
    $medicating = 'no';
    $bandaging = 'no';
    $woundCare = 'no';
    $diagnostics = 'no';
    $anesthesia = 'no';

    $notes = $_POST['TreatmentTrainingNotes'];


    if (!empty($_POST['small_mammals'])) {
        $smallMammals = 'yes';
    }
    if (!empty($_POST['large_mammals'])) {
        $largeMammals = 'yes';
    }
    if (!empty($_POST['rvs'])) {
        $rvs = 'yes';
    }
    if (!empty($_POST['eagles'])) {
        $eagles = 'yes';
    }
    if (!empty($_POST['small_raptors'])) {
        $smallRaptors = 'yes';
    }
    if (!empty($_POST['large_raptors'])) {
        $largeRaptors = 'yes';
    }
    if (!empty($_POST['reptiles'])) {
        $reptiles = 'yes';
    }
    if (!empty($_POST['vet'])) {
        $vet = 'yes';
    }
    if (!empty($_POST['technician'])) {
        $technician = 'yes';
    }
    if (!empty($_POST['vet_student'])) {
        $vetStudent = 'yes';
    }
    if (!empty($_POST['tech_student'])) {
        $techStudent = 'yes';
    }
    if (!empty($_POST['vet_assistant'])) {
        $vetAssistant = 'yes';
    }
    if (!empty($_POST['medicating'])) {
        $medicating = 'yes';
    }
    if (!empty($_POST['bandaging'])) {
        $bandaging = 'yes';
    }
    if (!empty($_POST['wound_care'])) {
        $woundCare = 'yes';
    }
    if (!empty($_POST['diagnostics'])) {
        $diagnostics = 'yes';
    }
    if (!empty($_POST['anesthesia'])) {
        $anesthesia = 'yes';
    }


    $newTrainingTreatment = new TrainingTreatment($VolunteerID, $DepartmentID, $smallMammals, $largeMammals, $rvs, $eagles, $smallRaptors, $largeRaptors, $reptiles, $vet, $technician, $vetStudent, $techStudent, $vetAssistant, $medicating, $bandaging, $woundCare, $diagnostics, $anesthesia, $notes);
    $VolunteerID = $newTrainingTreatment->getTreatmentTrainingVolunteerID();
    $DepartmentID = $newTrainingTreatment->getTreatmentTrainingDepartmentID();
    $smallMammals = $newTrainingTreatment->getTrainingSmallMammals();
    $largeMammals = $newTrainingTreatment->getTrainingLargeMammals();
    $rvs = $newTrainingTreatment->getTrainingRVS();
    $eagles = $newTrainingTreatment->getTrainingEagles();
    $smallRaptors = $newTrainingTreatment->getTrainingSmallRaptors();
    $largeRaptors = $newTrainingTreatment->getTrainingLargeRaptors();
    $reptiles = $newTrainingTreatment->getTrainingReptiles();

    $vet = $newTrainingTreatment->getTrainingVet();
    $technician = $newTrainingTreatment->getTrainingTechnician();
    $vetStudent = $newTrainingTreatment->getTrainingVetStudent();
    $techStudent = $newTrainingTreatment->getTrainingTechStudent();
    $vetAssistant = $newTrainingTreatment->getTrainingVetAssistant();

    $medicating = $newTrainingTreatment->getTrainingMedicating();
    $bandaging = $newTrainingTreatment->getTrainingBandaging();
    $woundCare = $newTrainingTreatment->getTrainingWoundCare();
    $diagnostics = $newTrainingTreatment->getTrainingDiagnostics();
    $anesthesia = $newTrainingTreatment->getTrainingAnesthesia();
    $notes = $newTrainingTreatment->getTreatmentTrainingNotes();
    $lastUpdatedBy = $newTrainingTreatment->getTrainingLastUpdatedBy();

    $sqlInsertTreatmentTraining = "INSERT INTO VolunteerDepartmentTreatment (VolunteerID, DepartmentID, SmallMammals, LargeMammals, RVS, Eagles, SmallRaptors, LargeRaptors, Reptiles, Vet, Technician, VetStudent, TechStudent, VetAssistant, Medicating, Bandaging, WoundCare, Diagnostics, Anesthesia, Notes, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
    //var_dump($sqlInsertTreatmentTraining);

    $stmt = mysqli_prepare($conn, $sqlInsertTreatmentTraining);
    $stmt->bind_param("iisssssssssssssssssss", $VolunteerID, $DepartmentID, $smallMammals, $largeMammals, $rvs, $eagles, $smallRaptors, $largeRaptors, $reptiles, $vet, $technician, $vetStudent, $techStudent, $vetAssistant, $medicating, $bandaging, $woundCare, $diagnostics, $anesthesia, $notes, $lastUpdatedBy);

    if ($stmt) {
        $stmt->execute();
    }


}

if (isset($_POST['SubmitAnimalCareTraining'])) {
    header("Refresh:0");
    $VolunteerID = $IsAnimalCareResults['VolunteerID'];
    $DepartmentID = 1;


    $sqlDeleteAnimalCareTraining = "delete from VolunteerDepartmentAnimalCare where VolunteerID = $VolunteerID";
    $stmt = mysqli_prepare($conn, $sqlDeleteAnimalCareTraining);
    if ($stmt) {
        $stmt->execute();
    }

    $reptileRoom = 0;
    $reptileSoak = 0;
    $snakeFeed = 0;
    $ICU = 0;
    $expandedICU = 0;
    $Aviary = 0;
    $Mammals = 0;
    $PUE = 0;
    $pueWeighDay = 0;
    $Fawns = 0;
    $Formula = 0;
    $Meals = 0;
    $raptorFeed = 0;
    $ISO = 0;

    $notes = $_POST['AnimalCareTrainingNotes'];

    if (!empty($_POST['reptile_room'])) {
        foreach ($_POST['reptile_room'] as $reptile_room) {

            $reptileRoom++;
    }}

    if (!empty($_POST['reptile_soak'])) {
    foreach ($_POST['reptile_soak'] as $reptile_soak) {

        $reptileSoak++;
    }}

    if (!empty($_POST['snake_feed'])) {
    foreach ($_POST['snake_feed'] as $snake_feed) {

        $snakeFeed++;
    }}

    if (!empty($_POST['icu'])) {
    foreach ($_POST['icu'] as $icu) {

        $ICU++;
    }}

    if (!empty($_POST['icu_expanded'])) {
        foreach ($_POST['icu_expanded'] as $icu_expanded) {

            $expandedICU++;
        }}

    if (!empty($_POST['aviary'])) {
        foreach ($_POST['aviary'] as $aviary) {

            $Aviary++;
        }}

    if (!empty($_POST['mammals'])) {
        foreach ($_POST['mammals'] as $mammals) {

            $Mammals++;
        }}

    if (!empty($_POST['pue'])) {
        foreach ($_POST['pue'] as $pue) {

            $PUE++;
        }}

    if (!empty($_POST['pue_weigh'])) {
        foreach ($_POST['pue_weigh'] as $pue) {

            $pueWeighDay++;
        }}
    if (!empty($_POST['fawns'])) {
        foreach ($_POST['fawns'] as $fawns) {

            $Fawns++;
        }}
    if (!empty($_POST['formula'])) {
        foreach ($_POST['formula'] as $formula) {

            $Formula++;
        }}
    if (!empty($_POST['meals'])) {
        foreach ($_POST['meals'] as $meal) {

            $Meals++;
        }}

    if (!empty($_POST['raptor_feed'])) {
        foreach ($_POST['raptor_feed'] as $raptor_feed) {

            $raptorFeed++;
        }}
    if (!empty($_POST['iso'])) {
        foreach ($_POST['iso'] as $iso) {

            $ISO++;
        }}


      $newAnimalCareTraining = new TrainingAnimalCare($VolunteerID, $DepartmentID, $reptileRoom,
          $reptileSoak, $snakeFeed, $ICU, $expandedICU, $Aviary, $Mammals, $PUE, $pueWeighDay, $Fawns,
          $Formula, $Meals, $raptorFeed, $ISO, $notes);

    $VolunteerID = $newAnimalCareTraining->getAnimalCareTrainingVolunteerID();
    $DepartmentID = $newAnimalCareTraining->getAnimalCareTrainingDepartmentID();

    $reptileRoom = $newAnimalCareTraining->getTrainingReptileRoom();
    $reptileSoak = $newAnimalCareTraining->getTrainingReptileSoak();
    $snakeFeed = $newAnimalCareTraining->getTrainingSnakeFeed();
    $ICU = $newAnimalCareTraining->getTrainingICU();
    $expandedICU = $newAnimalCareTraining->getTrainingExpandedICU();
    $Aviary = $newAnimalCareTraining->getTrainingAviary();
    $Mammals = $newAnimalCareTraining->getTrainingMammals();
    $PUE = $newAnimalCareTraining->getTrainingPUE();
    $pueWeighDay = $newAnimalCareTraining->getTrainingPueWeighDay();
    $Fawns = $newAnimalCareTraining->getTrainingFawns();
    $Formula = $newAnimalCareTraining->getTrainingFormula();
    $Meals = $newAnimalCareTraining->getTrainingMeals();
    $raptorFeed = $newAnimalCareTraining->getTrainingRaptorFeed();
    $ISO = $newAnimalCareTraining->getTrainingISO();
    $notes = $newAnimalCareTraining->getAnimalCareTrainingNotes();

    $lastUpdatedBy = $newAnimalCareTraining->getTrainingLastUpdatedBy();

    $sqlInsertAnimalCareTraining = "INSERT INTO VolunteerDepartmentAnimalCare (VolunteerID, DepartmentID, ReptileRoom, ReptileSoak, SnakeFeed, ICU, ExpandedICU, Aviary, Mammals, PUE, PueWeighDay, Fawns, Formula, Meals, RaptorFeed, ISO, Notes, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
   // var_dump($VolunteerID, $DepartmentID, $reptileRoom, $reptileSoak, $snakeFeed, $ICU, $expandedICU, $Aviary, $Mammals, $PUE, $pueWeighDay, $Fawns, $Formula, $Meals, $raptorFeed, $ISO, $notes);

    $stmt = mysqli_prepare($conn, $sqlInsertAnimalCareTraining);
    $stmt->bind_param("iiiiiiiiiiiiiiiiss", $VolunteerID, $DepartmentID, $reptileRoom, $reptileSoak, $snakeFeed, $ICU, $expandedICU, $Aviary, $Mammals, $PUE, $pueWeighDay, $Fawns, $Formula, $Meals, $raptorFeed, $ISO, $notes, $lastUpdatedBy);

    if ($stmt) {
        $stmt->execute();
    }



}


if (isset($_POST['SubmitTransportTraining'])) {
    header("Refresh:0");
    $VolunteerID = $IsTransportResults['VolunteerID'];
    $DepartmentID = 3;

    $sqlDeleteTransportTraining = "delete from VolunteerDepartmentTransport where VolunteerID = $VolunteerID";
    $stmt = mysqli_prepare($conn, $sqlDeleteTransportTraining);
    if ($stmt) {
        $stmt->execute();
    }

    $captureAndResistance = 'no';

    $distance = $_POST['WillingToTravel'];
    $speciesLimits = $_POST['SpeciesLimits'];
    $notes = $_POST['TransportTrainingNotes'];


    if (!empty($_POST['capture_resist_class'])) {
        $captureAndResistance = 'yes';
    }

    $newTransportTraining = new TrainingTransport($VolunteerID, $DepartmentID, $captureAndResistance, $distance, $speciesLimits, $notes);

    $captureAndResistance = $newTransportTraining->getTrainingCaptureAndResistance();
    $distance = $newTransportTraining->getTrainingDistance();
    $speciesLimits = $newTransportTraining->getTrainingSpeciesLimits();
    $notes = $newTransportTraining->getTransportTrainingNotes();

    $lastUpdatedBy = $newTransportTraining->getTrainingLastUpdatedBy();

    $sqlInsertTransportTraining = "INSERT INTO VolunteerDepartmentTransport (VolunteerID, DepartmentID, CaptureAndRestraint, WillingToTravel, SpeciesLimits, Notes, LastUpdatedBy, LastUpdated) VALUES(?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
    //  var_dump($sqlInsertTransportTraining);

    $stmt = mysqli_prepare($conn, $sqlInsertTransportTraining);
    $stmt->bind_param("iisssss", $VolunteerID, $DepartmentID, $captureAndResistance, $distance, $speciesLimits, $notes, $lastUpdatedBy);

    if ($stmt) {
        $stmt->execute();
    }






}

// Populate Outreach Training checkboxes
$ShadowTourCount = 'no';
$IntroTraining = 'no';
$CanLeadTour = 'no';
$OffSiteDisplay = 'no';
$OutreachNotes = 'none';

if($isOutreachVolunteer === 'yes') {
  //  var_dump($isOutreachVolunteer);
    if($isVolunteerDeptOutreach === 'yes') {
     //   var_dump($isVolunteerDeptOutreach);
        $VolunteerID = $IsOutreachResults['VolunteerID'];

        $sqlOutreachTraining = "SELECT ShadowTourCount, IntroTraining, CanLeadTour, OffsiteDisplay, Notes FROM VolunteerDepartmentOutreach WHERE VolunteerID = $VolunteerID;";
        $resultsOutreachTraining = mysqli_query($conn, $sqlOutreachTraining);

        while ($row = mysqli_fetch_array($resultsOutreachTraining)) {

            $ShadowTourCount = $row['ShadowTourCount'];
            $IntroTraining = $row['IntroTraining'];
            $CanLeadTour = $row['CanLeadTour'];
            $OffSiteDisplay = $row['OffsiteDisplay'];
            $OutreachNotes = $row['Notes'];

        }
    }
}

// Populate Treatment Training checkboxes
$SmallMammals = 'no';
$LargeMammals = 'no';
$RVS = 'no';
$Eagles = 'no';
$SmallRaptors = 'no';
$LargeRaptors = 'no';
$Reptiles = 'no';
$Vet = 'no';
$Technician = 'no';
$VetStudent = 'no';
$TechStudent = 'no';
$VetAssistant = 'no';
$Medicating = 'no';
$Bandaging = 'no';
$WoundCare = 'no';
$Diagnostics = 'no';
$Anesthesia = 'no';
$TreatmentNotes = 'none';

if($isTreatmentVolunteer === 'yes') {

    if($isVolunteerDeptTreatment === 'yes') {

        $VolunteerID = $IsTreatmentResults['VolunteerID'];

        $sqlTreatmentTraining = "SELECT SmallMammals, LargeMammals, RVS, Eagles, SmallRaptors, LargeRaptors, Reptiles, Vet, Technician, VetStudent, TechStudent, VetAssistant, Medicating, Bandaging, WoundCare, Diagnostics, Anesthesia, Notes FROM VolunteerDepartmentTreatment WHERE VolunteerID = $VolunteerID;";
        $resultsTreatmentTraining = mysqli_query($conn, $sqlTreatmentTraining);

        while ($row = mysqli_fetch_array($resultsTreatmentTraining)) {

            $SmallMammals = $row['SmallMammals'];
            $LargeMammals = $row['LargeMammals'];
            $RVS = $row['RVS'];
            $Eagles = $row['Eagles'];
            $SmallRaptors = $row['SmallRaptors'];
            $LargeRaptors = $row['LargeRaptors'];
            $Reptiles = $row['Reptiles'];
            $Vet = $row['Vet'];
            $Technician = $row['Technician'];
            $VetStudent = $row['VetStudent'];
            $TechStudent = $row['TechStudent'];
            $VetAssistant = $row['VetAssistant'];
            $Medicating = $row['Medicating'];
            $Bandaging = $row['Bandaging'];
            $WoundCare = $row['WoundCare'];
            $Diagnostics = $row['Diagnostics'];
            $Anesthesia = $row['Anesthesia'];
            $TreatmentNotes = $row['Notes'];


        }
    }
}

// Populate Animal Care Training checkboxes
$ReptileRoom = 0;
$ReptileSoak = 0;
$SnakeFeed = 0;
$icuSkill = 0;
$ExpandedICU = 0;
$AviarySkill = 0;
$MammalsSkill = 0;
$PUESkill = 0;
$pueWeighDaySkill = 0;
$FawnsSkill = 0;
$FormulaSkill = 0;
$MealsSkill = 0;
$raptorFeedSkill = 0;
$isoSkill = 0;
$AnimalCareNotes = 'none';

if($isAnimalCareVolunteer === 'yes') {
   // var_dump($isAnimalCareVolunteer);
    if($isVolunteerDeptAnimalCare === 'yes') {
     //   var_dump($isVolunteerDeptAnimalCare);

        $VolunteerID = $IsAnimalCareResults['VolunteerID'];

        $sqlAnimalCareTraining = "SELECT ReptileRoom, ReptileSoak, SnakeFeed, ICU, ExpandedICU, Aviary, Mammals, PUE, PueWeighDay, Fawns, Formula, Meals, RaptorFeed, ISO, Notes FROM VolunteerDepartmentAnimalCare WHERE VolunteerID = $VolunteerID;";
        $resultsAnimalCareTraining = mysqli_query($conn, $sqlAnimalCareTraining);

        while ($row = mysqli_fetch_array($resultsAnimalCareTraining)) {

            $ReptileRoom = $row['ReptileRoom'];
            $ReptileSoak = $row['ReptileSoak'];
            $SnakeFeed = $row['SnakeFeed'];
            $icuSkill = $row['ICU'];
            $ExpandedICU = $row['ExpandedICU'];
            $AviarySkill = $row['Aviary'];
            $MammalsSkill = $row['Mammals'];
            $PUESkill = $row['PUE'];
            $pueWeighDaySkill = $row['PueWeighDay'];
            $FawnsSkill = $row['Fawns'];
            $FormulaSkill = $row['Formula'];
            $MealsSkill = $row['Meals'];
            $raptorFeedSkill = $row['RaptorFeed'];
            $isoSkill = $row['ISO'];
            $AnimalCareNotes = $row['Notes'];
        }
    }
}

// Populate Transport fields
$CaptureAndResistance = 'no';
$Distance = 'none';
$SpeciesLimits = 'none';
$TransportNotes = 'none';

if($isTransportVolunteer === 'yes') {

    if($isVolunteerDeptTransport === 'yes') {

        $VolunteerID = $IsTransportResults['VolunteerID'];

        $sqlTransportTraining = "SELECT CaptureAndRestraint, WillingToTravel, SpeciesLimits, Notes FROM VolunteerDepartmentTransport WHERE VolunteerID = $VolunteerID;";
        $resultsTransportTraining = mysqli_query($conn, $sqlTransportTraining);

        while ($row = mysqli_fetch_array($resultsTransportTraining)) {

            $CaptureAndResistance = $row['CaptureAndRestraint'];
            $Distance = $row['WillingToTravel'];
            $SpeciesLimits = $row['SpeciesLimits'];
            $TransportNotes = $row['Notes'];

        }
    }
}

$adminRecords = $connPDO->prepare('SELECT AccountID,email,password FROM Account WHERE AccountID = :AccountID');
$adminRecords->bindParam(':AccountID', $_SESSION['AccountID']);
$adminRecords->execute();
$results = $adminRecords->fetch(PDO::FETCH_ASSOC);

$user = NULL;

if (count($results) > 0) {
    $user = $results;
}
$adminRecords = $connPDO->prepare('select PersonID, FirstName, MiddleInitial, LastName, PhoneNumber, Allergy, PhysicalLimitation FROM Person where AccountID = :AccountID');
$adminRecords->bindParam(':AccountID', $_SESSION['AccountID']);
$adminRecords->execute();
$results = $adminRecords->fetch(PDO::FETCH_ASSOC);

if (count($results) > 0) {
    $personInformation = $results;
}

$adminName = $personInformation['FirstName'] . " " . $personInformation['MiddleInitial'] . " " . $personInformation['LastName'];



?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Wildlife Center of Virginia | Training</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">


</head>
<body>
<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="img/personPicSmall.png" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $adminName ?></strong>
                             </span> <span class="text-muted text-xs block">Team Lead<b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="profile.html">Profile</a></li>
                            <li class="divider"></li>
                            <li><a href="login.html">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">

                    </div>
                </li>

                <li class = "active">
                    <a href="#"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-user"></i> <span class="nav-label">Profile</span></a></li>
                <li>
                    <a href="#"><i class="fa fa-clock-o"></i> <span class="nav-label">Update</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">Training</span>  </a>
                </li>
            </ul>
        </div>
    </nav> <!-- end of navigation -->


    <!-- TOP WHITE BAR WITH HAMBURGER MENU & LOGOUT BUTTON -->
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="login.html">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>

            </nav>
        </div>

        <!-- BEGINNING OF HEADER -->
        <div class = "row">
            <div class = "col-sm-12">
                <header id = "training-header-background" class="image-bg-fluid-height ">
                    <div class = "text-overlay">

                        <h1 class = "welcome-user"> TRAINING </h1> 
						
                    </div>
                </header>
            </div>
        </div>


        <h4><?php echo "Training for " . $volunteerName ?></h4>

        <!--Start of Accordion code-->
        <div class="wrapper wrapper-content">
            <form name = "adminTraining" method="post">
            <div class="row">

			<!--Start of panel 3-->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                            <a data-toggle="collapse" data-parents="#accordion" href="#collapse3">
                                <h3 class="accordion">Animal Care</h3>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse3" class="panel-collapse collapse">
                        <div id="panel-body">
                            <div class="accordion-padding">
                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Reptile Room</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="reptile_room[]"
                                                <?php if ($ReptileRoom > 0) { echo 'checked="checked"';} ?>></td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="reptile_room[]"
                                                <?php if ($ReptileRoom > 1) { echo 'checked="checked"';} ?>> </td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="reptile_room[]"
                                                <?php if ($ReptileRoom > 2) { echo 'checked="checked"';} ?>></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Reptile Room Soak Day</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="reptile_soak[]"
                                                <?php if ($ReptileSoak > 0) { echo 'checked="checked"';} ?>></td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="reptile_soak[]"
                                                <?php if ($ReptileSoak > 1) { echo 'checked="checked"';} ?>> </td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="reptile_soak[]"
                                                <?php if ($ReptileSoak > 2) { echo 'checked="checked"';} ?>></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Education Snake Feeding</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="snake_feed[]"
                                                <?php if ($SnakeFeed > 0) { echo 'checked="checked"';} ?>></td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="snake_feed[]"
                                                <?php if ($SnakeFeed > 1) { echo 'checked="checked"';} ?>> </td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="snake_feed[]"
                                                <?php if ($SnakeFeed > 2) { echo 'checked="checked"';} ?>></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">ICU</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="icu[]"
                                                <?php if ($icuSkill > 0) { echo 'checked="checked"';} ?>></td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="icu[]"
                                                <?php if ($icuSkill > 1) { echo 'checked="checked"';} ?>> </td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="icu[]"
                                                <?php if ($icuSkill > 2) { echo 'checked="checked"';} ?>></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Expanded ICU</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="icu_expanded[]"
                                                <?php if ($ExpandedICU > 0) { echo 'checked="checked"';} ?>></td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="icu_expanded[]"
                                                <?php if ($ExpandedICU > 1) { echo 'checked="checked"';} ?>> </td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="icu_expanded[]"
                                                <?php if ($ExpandedICU > 2) { echo 'checked="checked"';} ?>></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Aviary</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="aviary[]"
                                                <?php if ($AviarySkill > 0) { echo 'checked="checked"';} ?>></td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="aviary[]"
                                                <?php if ($AviarySkill > 1) { echo 'checked="checked"';} ?>> </td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="aviary[]"
                                                <?php if ($AviarySkill > 2) { echo 'checked="checked"';} ?>></td>
                                    </tr>
                                    </tbody>
                                </table>


                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Mammals</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="mammals[]"
                                                <?php if ($MammalsSkill > 0) { echo 'checked="checked"';} ?>></td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="mammals[]"
                                                <?php if ($MammalsSkill > 1) { echo 'checked="checked"';} ?>> </td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="mammals[]"
                                                <?php if ($MammalsSkill > 2) { echo 'checked="checked"';} ?>></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">PU&E</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="pue[]"
                                                <?php if ($PUESkill > 0) { echo 'checked="checked"';} ?>></td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="pue[]"
                                                <?php if ($PUESkill > 1) { echo 'checked="checked"';} ?>> </td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="pue[]"
                                                <?php if ($PUESkill > 2) { echo 'checked="checked"';} ?>></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">PU&E Weigh Day</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="pue_weigh[]"
                                                <?php if ($pueWeighDaySkill > 0) { echo 'checked="checked"';} ?>></td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="pue_weigh[]"
                                                <?php if ($pueWeighDaySkill > 1) { echo 'checked="checked"';} ?>> </td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="pue_weigh[]"
                                                <?php if ($pueWeighDaySkill > 2) { echo 'checked="checked"';} ?>></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Fawns</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="fawns[]"
                                                <?php if ($FawnsSkill > 0) { echo 'checked="checked"';} ?>></td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="fawns[]"
                                                <?php if ($FawnsSkill > 1) { echo 'checked="checked"';} ?>> </td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="fawns[]"
                                                <?php if ($FawnsSkill > 2) { echo 'checked="checked"';} ?>></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Formula</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="formula[]"
                                                <?php if ($FormulaSkill > 0) { echo 'checked="checked"';} ?>></td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="formula[]"
                                                <?php if ($FormulaSkill > 1) { echo 'checked="checked"';} ?>> </td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="formula[]"
                                                <?php if ($FormulaSkill > 2) { echo 'checked="checked"';} ?>></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Meals</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="meals[]"
                                                <?php if ($MealsSkill > 0) { echo 'checked="checked"';} ?>></td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="meals[]"
                                                <?php if ($MealsSkill > 1) { echo 'checked="checked"';} ?>> </td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="meals[]"
                                                <?php if ($MealsSkill > 2) { echo 'checked="checked"';} ?>></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Raptor Feed</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="raptor_feed[]"
                                                <?php if ($raptorFeedSkill > 0) { echo 'checked="checked"';} ?>></td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="raptor_feed[]"
                                                <?php if ($raptorFeedSkill > 1) { echo 'checked="checked"';} ?>> </td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="raptor_feed[]"
                                                <?php if ($raptorFeedSkill > 2) { echo 'checked="checked"';} ?>></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">ISO</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="iso[]"
                                                <?php if ($isoSkill > 0) { echo 'checked="checked"';} ?>></td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="iso[]"
                                                <?php if ($isoSkill > 1) { echo 'checked="checked"';} ?>> </td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="iso[]"
                                                <?php if ($isoSkill > 2) { echo 'checked="checked"';} ?>></td>
                                    </tr>
                                    </tbody>
                                </table>
                                </div>
                                    <div class="form-group"><label>Notes</label> <textarea name="AnimalCareTrainingNotes" rows="4" class="form-control"><?php echo $AnimalCareNotes ?></textarea></div>

                                    <button class="btn btn-sm btn-primary pull-right" name="SubmitAnimalCareTraining" type="submit" ><strong>Save</strong></button>


                            </div>
                        </div>

                    </div>
                </div>
			
                <!--Start of panel 1-->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a data-toggle="collapse" data-parents="#accordion" href="#collapse1">
                            <h3 class="accordion">Outreach</h3>
                        </a>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse">
                        <div id="panel-body">

                            <div>
                                <div class="accordion-padding">
                                    <p>TOURS	</p>
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td class="form_table" class="avail_space">Shadow</td>
                                            <td class="form_table" class="avail_space"><input type="checkbox" name="shadow[]"
                                                    <?php if ($ShadowTourCount > 0) { echo 'checked="checked"';} ?>></td>
                                            <td class="form_table" class="avail_space"><input type="checkbox" name="shadow[]"
                                                <?php if($ShadowTourCount > 1) { echo 'checked="checked"'; }?>> </td>
                                            <td class="form_table" class="avail_space"><input type="checkbox" name="shadow[]"
                                                    <?php if($ShadowTourCount > 2) { echo 'checked="checked"'; }?>></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <table>
                                        <tbody>
                                        <tr>
                                            <td class="form_table" class="avail_space">Intro Portion</td>
                                            <td class="form_table" class="avail_space"><input type="checkbox" name="intro_portion"
                                                    <?php if($IntroTraining === "yes") { echo 'checked="checked"'; }?>></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <table>
                                        <tbody>
                                        <tr>
                                            <td class="form_table" class="avail_space">Lead Alone</td>
                                            <td class="form_table" class="avail_space"><input type="checkbox" name="lead_alone"
                                                    <?php if($CanLeadTour === "yes") { echo 'checked="checked"'; }?>></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div>
                                        <table>
                                            <tbody>
                                            <tr>
                                                <td class="form_table" class="avail_space">Offsite Displays</td>
                                                <td class="form_table" class="avail_space"><input type="checkbox" name="offSite_displays"
                                                        <?php if($OffSiteDisplay === "yes") { echo 'checked="checked"'; }?>></td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <br>
                                    </div>
                                    <div class="form-group"><label>Notes</label> <textarea name="OutreachTrainingNotes" rows="4" class="form-control" ><?php echo $OutreachNotes ?></textarea></div>

                                    <button class="btn btn-sm btn-primary pull-right" name="SubmitOutreachTraining" type="submit" ><strong>Save</strong></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
				
				                <!--Start of panel 4-->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                            <a data-toggle="collapse" data-parents="#accordion" href="#collapse4">
                                <h3 class="accordion">Transport</h3>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse4" class="panel-collapse collapse">
                        <div id="panel-body">
                            <div class="accordion-padding">
                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Capture and Resistance Class</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="capture_resist_class"
                                                <?php if($CaptureAndResistance === "yes") { echo 'checked="checked"'; }?>></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <br>
                                <div class="form-group"><label>Distance Willing To Travel</label> <textarea rows="4" name="WillingToTravel" class="form-control"><?php echo $Distance ?></textarea></div>


                                <div class="form-group"><label>Species Limitations</label> <textarea rows="4" name="SpeciesLimits" class="form-control"><?php echo $SpeciesLimits ?></textarea></div>

                                <div class="form-group"><label>Notes</label> <textarea rows="4" name="TransportTrainingNotes" class="form-control"><?php echo $TransportNotes ?></textarea></div>
                                <button class="btn btn-sm btn-primary pull-right" name="SubmitTransportTraining" type="submit" ><strong>Save</strong></button>

                            </div>
                        </div>

                    </div>
                </div>


                <!--Start of panel 2-->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                            <a data-toggle="collapse" data-parents="#accordion" href="#collapse2">
                                <h3 class="accordion">Treatment</h3>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse">
                        <div id="panel-body">
                            <div class="accordion-padding">
                                <div>
                                    <p>HANDLING SKILLS</p>
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td class="form_table" class="avail_space">Small Mammals</td>
                                            <td class="form_table" class="avail_space"><input type="checkbox" name="small_mammals"
                                                    <?php if($SmallMammals === "yes") { echo 'checked="checked"'; }?>></td>

                                        </tr>
                                        </tbody>
                                    </table>

                                    <table>
                                        <tbody>
                                        <tr>
                                            <td class="form_table" class="avail_space">Large Mammals</td>
                                            <td class="form_table" class="avail_space"><input type="checkbox" name="large_mammals"
                                                    <?php if($LargeMammals === "yes") { echo 'checked="checked"'; }?>></td>

                                        </tr>
                                        </tbody>
                                    </table>

                                    <table>
                                        <tbody>
                                        <tr>
                                            <td class="form_table" class="avail_space">RVS</td>
                                            <td class="form_table" class="avail_space"><input type="checkbox" name="rvs"
                                                    <?php if($RVS === "yes") { echo 'checked="checked"'; }?>></td>

                                        </tr>
                                        </tbody>
                                    </table>

                                    <table>
                                        <tbody>
                                        <tr>
                                            <td class="form_table" class="avail_space">Eagles</td>
                                            <td class="form_table" class="avail_space"><input type="checkbox" name="eagles"
                                                    <?php if($Eagles === "yes") { echo 'checked="checked"'; }?>></td>

                                        </tr>
                                        </tbody>
                                    </table>

                                    <table>
                                        <tbody>
                                        <tr>
                                            <td class="form_table" class="avail_space">Small Raptors</td>
                                            <td class="form_table" class="avail_space"><input type="checkbox" name="small_raptors"
                                                    <?php if($SmallRaptors === "yes") { echo 'checked="checked"'; }?>></td>

                                        </tr>
                                        </tbody>
                                    </table>

                                    <table>
                                        <tbody>
                                        <tr>
                                            <td class="form_table" class="avail_space">Large Raptors</td>
                                            <td class="form_table" class="avail_space"><input type="checkbox" name="large_raptors"
                                                    <?php if($LargeRaptors === "yes") { echo 'checked="checked"'; }?>></td>

                                        </tr>
                                        </tbody>
                                    </table>

                                    <table>
                                        <tbody>
                                        <tr>
                                            <td class="form_table" class="avail_space">Reptiles</td>
                                            <td class="form_table" class="avail_space"><input type="checkbox" name="reptiles"
                                                    <?php if($Reptiles === "yes") { echo 'checked="checked"'; }?>></td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <p>VETERINARY TRAINING</p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Vet</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="vet"
                                                <?php if($Vet === "yes") { echo 'checked="checked"'; }?>></td>

                                    </tr>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Technician</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="technician"
                                                <?php if($Technician === "yes") { echo 'checked="checked"'; }?>></td>

                                    </tr>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Vet Student</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="vet_student"
                                                <?php if($VetStudent === "yes") { echo 'checked="checked"'; }?>></td>

                                    </tr>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Tech Student</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="tech_student"
                                                <?php if($TechStudent === "yes") { echo 'checked="checked"'; }?>></td>

                                    </tr>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Vet Assistant</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="vet_assistant"
                                                <?php if($VetAssistant === "yes") { echo 'checked="checked"'; }?>></td>

                                    </tr>
                                    </tbody>
                                </table>

                                <br>
                                <p>PATIENT CARE SKILLS</p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Medicating</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="medicating"
                                                <?php if($Medicating === "yes") { echo 'checked="checked"'; }?>></td>

                                    </tr>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Bandaging</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="bandaging"
                                                <?php if($Bandaging === "yes") { echo 'checked="checked"'; }?>></td>

                                    </tr>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Wound Care</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="wound_care"
                                                <?php if($WoundCare === "yes") { echo 'checked="checked"'; }?>></td>

                                    </tr>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Diagnostics</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="diagnostics"
                                                <?php if($Diagnostics === "yes") { echo 'checked="checked"'; }?>></td>

                                    </tr>
                                    </tbody>
                                </table>
                            <div>
                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="form_table" class="avail_space">Anesthesia</td>
                                        <td class="form_table" class="avail_space"><input type="checkbox" name="anesthesia"
                                                <?php if($Anesthesia === "yes") { echo 'checked="checked"'; }?>></td>

                                    </tr>
                                    </tbody>
                                </table>

                                <br>
                            </div>
                                <div class="form-group"><label>Notes</label> <textarea name="TreatmentTrainingNotes" rows="4" class="form-control"><?php echo $TreatmentNotes ?></textarea></div>
                                <button class="btn btn-sm btn-primary pull-right" name="SubmitTreatmentTraining" type="submit" ><strong>Save</strong></button>
                            </div>
                        </div>
                    </div>
                </div>

                


            </div>


            <div class="col-sm-12">

            </div>
            </form>
        </div><!-- end row -->
    </div> <!-- end row -->



</div>

<!-- Mainly scripts -->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Flot -->
<script src="js/plugins/flot/jquery.flot.js"></script>
<script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="js/plugins/flot/jquery.flot.spline.js"></script>
<script src="js/plugins/flot/jquery.flot.resize.js"></script>
<script src="js/plugins/flot/jquery.flot.pie.js"></script>
<script src="js/plugins/flot/jquery.flot.symbol.js"></script>
<script src="js/plugins/flot/jquery.flot.time.js"></script>

<!-- Peity -->
<script src="js/plugins/peity/jquery.peity.min.js"></script>
<script src="js/demo/peity-demo.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<!-- jQuery UI -->
<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Jvectormap -->
<script src="js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- EayPIE -->
<script src="js/plugins/easypiechart/jquery.easypiechart.js"></script>

<!-- Sparkline -->
<script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- Sparkline demo data  -->
<script src="js/demo/sparkline-demo.js"></script>


<!-- Modal -->
<div class="modal fade" id="checkInUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="checkInTitle">CHECK IN TO VOLUNTEER</h3>
                <button type="button" id = "closeCheckIn" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body centered">
                <h1> 10:00:32 AM </h1>
                <h4> SELECT VOLUNTEER TYPE </h4>
                <select class = "selection-box">
                    <option value="volvo">Animal Care</option>
                    <option value="saab">Outreach</option>
                    <option value="mercedes">Transport</option>
                    <option value="audi">Vet Team</option>
                    <option value="audi">Other</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                <button type="button" class="btn-edit-form">CHECK IN</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="checkInUserTrans" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="checkInTitle">CHECK IN TO VOLUNTEER</h3>
                <button type="button" id = "closeCheckIn" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body centered">
                <h1> 10:00:32 AM </h1>
                <div class = "orangeBackground">
                    <h4 class = "whiteText"> SELECT VOLUNTEER TYPE </h4>
                    <select class = "selection-box">
                        <option value="mercedes">Transport</option>
                    </select>
                </div><!-- end of orange background -->
                <div class = "row">
                    <div class = "col-sm-11">

                        <table class = "moveDown ">
                            <tbody class = "">
                            <tr>
                                <td class = "avail_space space-left text-left">SPECIES TRANSPORTED </td>
                                <td class = "avail_space pull-left">
                                    <select class = "selection-box pull-left">
                                        <option value="mercedes">Reptile</option>
                                        <option value="mercedes">Bird</option>
                                        <option value="mercedes">Dinosaur</option>
                                        <option value="mercedes">Unicorn</option>
                                    </select>
                                </td>
                                <td class = "avail_space"> </td>
                            </tr>

                            <tr>
                                <td class = "avail_space space-left text-left">MILES DRIVEN </td>
                                <td class = "avail_space pull-left"><input type="text" name="numMiles" value="" size="5"></td>
                                <td class = "avail_space"> </td>
                            </tr>

                            <tr>
                                <td class = "avail_space space-left text-left"> DESTINATION ADDRESS </td>
                                <td class = "avail_space pull-left"><input type="text" name="destinationAddress" value="" size = "20"></td>
                                <td class = "avail_space"></td>
                            </tr>

                            <tr>
                                <td class = "avail_space space-left text-left">  </td>
                                <td class = "avail_space space-left text-left">CITY<input type="text" name="transportCity" value="" size = "20"></td>
                                <td class = "avail_space space-left text-left"> STATE
                                    <select name="PersonState">
                                        <option value="VA">Virginia</option>
                                        <option value="WV">West Virginia</option>
                                        <option value="MD">Maryland</option>
                                        <option value="n/a">----------</option>
                                        <option value="AL">Alabama</option>
                                        <option value="AK">Alaska</option>
                                        <option value="AZ">Arizona</option>
                                        <option value="AR">Arkansas</option>
                                        <option value="CA">California</option>
                                        <option value="CO">Colorado</option>
                                        <option value="CT">Connecticut</option>
                                        <option value="DE">Delaware</option>
                                        <option value="DC">District Of Columbia</option>
                                        <option value="FL">Florida</option>
                                        <option value="GA">Georgia</option>
                                        <option value="HI">Hawaii</option>
                                        <option value="ID">Idaho</option>
                                        <option value="IL">Illinois</option>
                                        <option value="IN">Indiana</option>
                                        <option value="IA">Iowa</option>
                                        <option value="KS">Kansas</option>
                                        <option value="KY">Kentucky</option>
                                        <option value="LA">Louisiana</option>
                                        <option value="ME">Maine</option>
                                        <option value="MA">Massachusetts</option>
                                        <option value="MI">Michigan</option>
                                        <option value="MN">Minnesota</option>
                                        <option value="MS">Mississippi</option>
                                        <option value="MO">Missouri</option>
                                        <option value="MT">Montana</option>
                                        <option value="NE">Nebraska</option>
                                        <option value="NV">Nevada</option>
                                        <option value="NH">New Hampshire</option>
                                        <option value="NJ">New Jersey</option>
                                        <option value="NM">New Mexico</option>
                                        <option value="NY">New York</option>
                                        <option value="NC">North Carolina</option>
                                        <option value="ND">North Dakota</option>
                                        <option value="OH">Ohio</option>
                                        <option value="OK">Oklahoma</option>
                                        <option value="OR">Oregon</option>
                                        <option value="PA">Pennsylvania</option>
                                        <option value="RI">Rhode Island</option>
                                        <option value="SC">South Carolina</option>
                                        <option value="SD">South Dakota</option>
                                        <option value="TN">Tennessee</option>
                                        <option value="TX">Texas</option>
                                        <option value="UT">Utah</option>
                                        <option value="VT">Vermont</option>
                                        <option value="WA">Washington</option>
                                        <option value="WI">Wisconsin</option>
                                        <option value="WY">Wyoming</option>
                                    </select>

                                <td class = "avail_space"></td>
                            </tr>

                            <tr>
                                <td class = "avail_space space-left text-left"> ZIP CODE </td>
                                <td class = "avail_space pull-left"><input type="text" name="destinationAddress" value="" size = "5"></td>
                                <td class = "avail_space"></td>
                            </tr>

                            </tbody>
                        </table>


                    </div><!-- end of selection box row -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                    <button type="button" class="btn-edit-form">CHECK IN</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

