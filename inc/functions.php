<?php

require_once("config.php"); // include database configuration file


// Function to establish a database connection
function connectToDatabase($servername, $username, $password, $database)
{
    mysqli_report(MYSQLI_REPORT_OFF); // handle mysqli error

    $conn = @new mysqli($servername, $username, $password, $database);

    global $connectDBMessage;
    if ($conn->connect_errno) {
        echo "Database: " . $database . "<br>Connected failed<br>";
        $connectDBMessage =  "Database: " . $database . "<br>Connected failed<br>";
        die("ERROR: Could not connect. <strong>" . $conn->connect_error . "</strong>");
    } else {
        // echo "Database: " . $database . "<br>Connected successfully<br>";
        $connectDBMessage = "Database: <strong>" . $database . "</strong> Connected successfully<br>You can log in now.<br>";
    }
    return $conn;
}

// other functions
function printArray($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function printArrayAsTable($array)
{
    echo "<h2>Query Results:</h2>";
    echo "<?php if (empty($array)) : ?>";
    echo "<p>No results found.</p>";
    echo "<?php else: ?>";
    echo "<p>Found <?php echo count($array); ?> results.</p>";

    echo "<table>";
    foreach ($array as $key => $value) {
        echo "<tr>";
        echo "<td>" . $key . "</td>";
        foreach ($value as $key => $value) {
            echo "<td>" . $value . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    echo "<?php endif; ?>";
    echo "<br>";
}

function printTable($array)
{
    echo '<div class="container">';
    echo '<div class="row">';
    echo '<div class="col-md-12">';
    echo '<h2>Query Results:</h2>';
    if (empty($array)) :
        echo '<p>No results found.111</p>';
    else :
        echo '<p>Found ' . count($array) . ' results.</p>';

        echo '<table class="table table-striped"><thead><tr>';
        echo '<th>Num</th>';
        foreach ($array[0] as $key => $value) {
            echo '<th>' . $key . '</th>';
        }
        echo '</tr></thead>';
        echo '<tbody>';
        foreach ($array as $key => $value) {
            echo "<tr>";
            echo "<td>" . $key . "</td>";
            foreach ($value as $key => $value) {
                echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    endif;
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo "<br>";
}

function login($db, $username, $password)
{
    $stmt = $db->prepare("SELECT * FROM Police 
        WHERE Police_username = ? AND Police_password = ?");

    $username = clean_input($username);
    $password = clean_input($password);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $row['Police_role'];
        // session_start();
        header("Location: dashboard.php"); // redirect 

        exit;
    } else {
        global $LoginError;
        $LoginError = "<p>Invalid username or password.</p>";
    }
}

function logout()
{
    // unset any session variables
    $_SESSION = [];

    // expire cookie
    if (!empty($_COOKIE[session_name()])) {
        setcookie(session_name(), "", time() - 42000);
    }

    // destroy session
    session_destroy();
}

function queryPeople($db, $name)
{
    $sql = "SELECT * FROM People WHERE People_name LIKE '%" . $name . "%' or People_licence LIKE '%" . $name . "%'";
    $result = mysqli_query($db, $sql);
    $people = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $people;
}

function addPerson($db, $name, $licence, $address = null, $personDOB = null, $personPoints = null)
{
    $people = queryPeople($db, $licence);
    if (!empty($people)) {
        echo "People already exists in database. People licence is: " . $licence . "<br>";
        return false;
    }

    $name = clean_input($name);
    $licence = clean_input($licence);

    if ($address) {
        $address = clean_input($address);
    }
    if ($personDOB) {
        $personDOB = clean_input($personDOB);
    }
    if ($personPoints) {
        $personPoints = clean_input($personPoints);
    }

    // add person to database
    // if ($address && $personDOB && $personPoints) {
    //     $stmt = $db->prepare("INSERT INTO People (People_name, People_licence, People_address, People_DOB, People_points) VALUES (?, ?, ?, ?, ?)");
    //     $stmt->bind_param("sssss", $name, $licence, $address, $personDOB, $personPoints);
    // } elseif ($address && $personDOB) {
    //     $stmt = $db->prepare("INSERT INTO People (People_name, People_licence, People_address, People_DOB) VALUES (?, ?, ?, ?)");
    //     $stmt->bind_param("ssss", $name, $licence, $address, $personDOB);
    // } elseif ($address && $personPoints) {
    //     $stmt = $db->prepare("INSERT INTO People (People_name, People_licence, People_address, People_points) VALUES (?, ?, ?, ?)");
    //     $stmt->bind_param("ssss", $name, $licence, $address, $personPoints);
    // } elseif ($personDOB && $personPoints) {
    //     $stmt = $db->prepare("INSERT INTO People (People_name, People_licence, People_DOB, People_points) VALUES (?, ?, ?, ?)");
    //     $stmt->bind_param("ssss", $name, $licence, $personDOB, $personPoints);
    // } else
    if ($address) {
        $stmt = $db->prepare("INSERT INTO People (People_name, People_licence, People_address) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $licence, $address);
        // } elseif ($personDOB) {
        //     $stmt = $db->prepare("INSERT INTO People (People_name, People_licence, People_DOB) VALUES (?, ?, ?)");
        //     $stmt->bind_param("sss", $name, $licence, $personDOB);
        // } elseif ($personPoints) {
        //     $stmt = $db->prepare("INSERT INTO People (People_name, People_licence, People_points) VALUES (?, ?, ?)");
        //     $stmt->bind_param("sss", $name, $licence, $personPoints);
    } else {
        $stmt = $db->prepare("INSERT INTO People (People_name, People_licence) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $licence);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // echo "New person added successfully. Person licence is: " . $licence . "<br>";
    return $result;
}

function findPersonIDByLicence($db, $licence)
{
    $people = queryPeople($db, $licence);

    if (empty($people)) {
        return null;
    } elseif (count($people) == 1) {
        return $people[0]['People_ID'];
    } else {
        // echo "More than one people found. Please check.<br>";
        return null;
    }

}

function findVehicleIDByLicence($db, $licence)
{
    $vehicles = queryVehicle($db, $licence);

    if (empty($vehicles)) {
        return null;
    } elseif (count($vehicles) == 1) {
        return $vehicles[0]['Vehicle_ID'];
    } else {
        echo "Invalid vehicle plate number. Please check.<br>";
        // return $vehicles[0]['Vehicle_ID'];
        return null;
    }

}

function findOffenceIDByDescription($db, $description)
{
    $offences = queryOffences($db, $description);

    if (empty($offences)) {
        return null;
    } elseif (count($offences) == 1) {
        return $offences[0]['Offence_ID'];
    } else {
        // echo "More than one offence found. Please check.<br>";
        return $offences[0]['Offence_ID'];
    }


    // foreach ($offences as $offence) {
    //     if ($offence['Offence_description'] == $description) {
    //         return $offence['Offence_ID']; // ID
    //     }
    // }
    // return null; 
}

function findIncidentIDByReport($db, $report)
{
    $incidents = queryIncident($db, $report);

    if (empty($incidents)) {
        return null;
    } elseif (count($incidents) == 1) {
        return $incidents[0]['Incident_ID'];
    } else {
        // echo "More than one incident found. Please check.<br>";
        return $incidents[0]['Incident_ID'];
    }

    // foreach ($incidents as $incident) {
    //     if ($incident['Vehicle_licence'] == $report) {
    //         return $incident['Vehicle_ID']; // ID
    //     }
    // }
    // return null; 
}

function queryVehicle($db, $info)
{
    $stmt = $db->prepare("SELECT Vehicle.*, People.* FROM Vehicle 
        LEFT JOIN Ownership ON Vehicle.Vehicle_ID = Ownership.Vehicle_ID 
        LEFT JOIN People ON Ownership.People_ID = People.People_ID 
        WHERE Vehicle.Vehicle_licence LIKE ?");

    $info = "%$info%";
    $stmt->bind_param("s", $info);
    $stmt->execute();
    $result = $stmt->get_result();

    $vehicle = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $vehicle;
}

function queryIncident($db, $info)
{
    $stmt = $db->prepare("SELECT Incident.*, Vehicle.*, People.*, Offence.* FROM Incident 
        LEFT JOIN Vehicle ON Incident.Vehicle_ID = Vehicle.Vehicle_ID 
        LEFT JOIN People ON Incident.People_ID = People.People_ID 
        LEFT JOIN Offence ON Incident.Offence_ID = Offence.Offence_ID 
        WHERE Incident.Incident_Date LIKE ? OR Incident.Incident_Report LIKE ?");

    $info = "%$info%";
    $stmt->bind_param("ss", $info, $info);
    $stmt->execute();
    $result = $stmt->get_result();

    $incident = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $incident;
}

function queryAuditLog($db, $info)
{
    $stmt = $db->prepare("SELECT * FROM Log WHERE username LIKE ? or operation_time LIKE ? or operation_type LIKE ? or details LIKE ? ORDER BY operation_time DESC");

    $info = "%$info%";
    $stmt->bind_param("ssss", $info, $info, $info, $info);
    $stmt->execute();
    $result = $stmt->get_result();

    $log = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $log;
}

function addAuditLog($db, $username, $operationType, $details)
{
    $stmt = $db->prepare("INSERT INTO Log (username, operation_type, details) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $operationType, $details);
    $stmt->execute();
}


function queryOffences($db, $info)
{
    $stmt = $db->prepare("SELECT * FROM Offence WHERE Offence_ID LIKE ? OR Offence_description LIKE ?");

    $info = "%$info%";
    $stmt->bind_param("ss", $info, $info);
    $stmt->execute();
    $result = $stmt->get_result();

    $offences = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $offences;
}

function checkOwnership($db, $vehicleID, $peopleID)
{
    $stmt = $db->prepare("SELECT * FROM Ownership WHERE Vehicle_ID = ? AND People_ID = ?");
    $stmt->bind_param("ss", $vehicleID, $peopleID);
    $stmt->execute();
    $result = $stmt->get_result();

    $ownership = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $ownership;
}


function addVehicle($db, $vehicleType, $vehicleColour, $vehicleLicence, $peopleLicence)
{

    $vehicleType = clean_input($vehicleType);
    $vehicleColour = clean_input($vehicleColour);
    $vehicleLicence = clean_input($vehicleLicence);
    $peopleLicence = clean_input($peopleLicence);

    $db->begin_transaction();

    try {
        $db->autocommit(FALSE); //turn on transactions

        // check if people exists
        $searchedPeople = queryPeople($db, $peopleLicence);

        if (empty($searchedPeople)) {
            // echo "Person not found. Please add this person: " . $peopleLicence . " first.<br>";
            return false;
        } elseif (count($searchedPeople) > 1) {
            return false;
        }
        // exactly one people found, then add vehicle
        else {
            // echo "Found this person. People licence is: " . $peopleLicence . "<br>Adding vehicles.<br>";
            $peopleID = findPersonIDByLicence($db, $peopleLicence);

            $searchedVehicle = queryVehicle($db, $vehicleLicence);
            if (empty($searchedVehicle)) {

                // echo "This is a new vehicle. Adding vehicle.<br>";

                // add vehicle to database
                $stmt = $db->prepare("INSERT INTO Vehicle (Vehicle_type, Vehicle_colour, Vehicle_licence) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $vehicleType, $vehicleColour, $vehicleLicence);
                $stmt->execute();
                echo "New vehicle added successfully. Vehicle licence is: " . $vehicleLicence . "<br>";
                $vehicleID = findVehicleIDByLicence($db, $vehicleLicence);

                // new vehicle added, add ownership to database
                $stmt = $db->prepare("INSERT INTO Ownership (People_ID, Vehicle_ID) VALUES (?, ?)");
                $stmt->bind_param("ss", $peopleID, $vehicleID);
                $stmt->execute();
                echo "New ownership added successfully. Vehicle licence is: " . $vehicleLicence . " and owner is: " . $peopleLicence . "<br>";

                $db->commit();
            } else {
                echo "This vehicle is an existed vehicle. Vehicle licence is: " . $vehicleLicence . "<br>";
                $vehicleID = findVehicleIDByLicence($db, $vehicleLicence);

                // add ownership to database
                $checkedOwnership = checkOwnership($db, $vehicleID, $peopleID);
                if (!empty($checkedOwnership)) {
                    echo "Ownership already exists and didn't change. Vehicle licence is: " . $vehicleLicence . " and owner is: " . $peopleLicence . "<br>";
                    return false;
                } else {
                    $stmt = $db->prepare("INSERT INTO Ownership (People_ID, Vehicle_ID) VALUES (?, ?)");
                    $stmt->bind_param("ss", $peopleID, $vehicleID);
                    $stmt->execute();
                    echo "New ownership added successfully. Vehicle licence is: " . $vehicleLicence . " and owner is: " . $peopleLicence . "<br>";

                    $db->commit();
                }
            }
        }

        $db->autocommit(TRUE); // turn off transactions + commit queued queries

    } catch (mysqli_sql_exception $exception) {
        $db->rollback();
        throw $exception;
    }
}

function addIncident($db, $vehicleID, $peopleID, $incidentDate, $incidentReport, $offenceID)
{

    $db->begin_transaction();

    try {
        $db->autocommit(FALSE); //turn on transactions

        // check if incident exists
        $sql = "SELECT * FROM Incident WHERE Vehicle_ID = " . $vehicleID . " and People_ID = " . $peopleID . " and Incident_Date = '" . $incidentDate . "' and Incident_Report = '" . $incidentReport . "' and Offence_ID = " . $offenceID;
        $result = mysqli_query($db, $sql);
        $searchedIncident = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if (!empty($searchedIncident)) {
            // echo "Incident already exists. Incident report is: " . $incidentReport . "<br>";
            return false;
        }

        // add incident to database
        $stmt = $db->prepare("INSERT INTO Incident (Vehicle_ID, People_ID, Incident_Date, Incident_Report, Offence_ID) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $vehicleID, $peopleID, $incidentDate, $incidentReport, $offenceID);
        $excResult = $stmt->execute();
        if ($excResult) {
            echo "New incident added successfully. Incident report is: " . $incidentReport . "<br>";

            $db->commit();
        } else {
            echo "Failed to add incident. Incident report is: " . $incidentReport . "<br>";
            return false;
        }
    } catch (mysqli_sql_exception $exception) {
        $db->rollback();
        throw $exception;
    } finally {
        $db->autocommit(TRUE); // turn off transactions + commit queued queries
    }
}

function clean_input($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// adapted from http://www.php.net/header
function redirect($destination)
{
    // handle URL
    if (preg_match("/^https?:\/\//", $destination)) {
        header("Location: " . $destination);
    }

    // handle absolute path
    else if (preg_match("/^\//", $destination)) {
        $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
        $host = $_SERVER["HTTP_HOST"];
        header("Location: $protocol://$host$destination");
    }

    // handle relative path
    else {
        // adapted from http://www.php.net/header
        $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
        $host = $_SERVER["HTTP_HOST"];
        $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
        header("Location: $protocol://$host$path/$destination");
    }

    // exit immediately since we're redirecting anyway
    exit;
}

function pleaseLogin()
{
    if (!isset($_SESSION['username'])) {
        echo "<p>You are not logged in.</p>";
        echo "<p>Please login first.</p>";
        echo "<p><a href='login.php'>Login</a></p>";
        // redirect("login.php");
        require_once "inc/footer.php";
        exit;
    }
}

function findTitle($string)
{
    // chunk_split($string, "/");

    $title = "";
    $title = substr($string, 5, strpos($string, ".") - 5);
    if (strpos($title, "_")) {
        $title = str_replace("_", " ", $title);
        // capitalize first letter of each word
    }
    $title = ucwords($title);

    return $title;
}


function associateFineToReport($db, $fineAmount, $finePoints, $incidentID)
{
    // sql to insert fine
    $stmt = $db->prepare("INSERT INTO Fines (Fine_amount, Fine_points, Incident_ID) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $fineAmount, $finePoints, $incidentID);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Fine associated to report successfully.";
    } else {
        echo "Error associating fine to report.";
    }
}

function addFine($db, $fineAmount, $finePoints, $incidentID)
{
    // check if fine exists
    $sql = "SELECT * FROM Fines WHERE Incident_ID = " . $incidentID;
    $result = mysqli_query($db, $sql);
    $searchedFine = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (!empty($searchedFine)) {
        echo "This incidents has been already assigned a fine. Incident ID is: " . $incidentID . "<br>";
        return false;
    }

    // add fine to database
    $stmt = $db->prepare("INSERT INTO Fines (Fine_amount, Fine_points, Incident_ID) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $fineAmount, $finePoints, $incidentID);
    $excResult = $stmt->execute();
    if ($excResult) {
        echo "New fine added successfully.";
    } else {
        echo "Failed to add fine. Incident ID is: " . $incidentID . "<br>";
        return false;
    }
}
