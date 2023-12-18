<?php
// get_people.php
include_once 'config.php';
include_once("functions.php");

$q = $_GET['q'];

// search database for matched people
$people = queryPeople($db, $q);

if (empty($people)) {
    echo "<p>No results found.</p>";
    echo "<p>Please add this person first. </p>";
    // echo "<a href='add_person.php'>Add Person</a>";
    exit;
}

// change array to json
echo json_encode($people);


// generate table
// foreach ($people as $person) {
//     echo "<div onclick='selectOwner(\"{$person['People_name']} {$person['People_licence']}\")'>" . $person['People_name'] . " - " . $person['People_licence'] . "</div>";
// }
?>