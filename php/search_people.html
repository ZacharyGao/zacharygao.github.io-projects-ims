<?php include_once("inc/config.php"); ?>
<?php include_once "inc/header.php"; ?>

<?php
$info = $infoError = "";

if (isset($_SESSION['username'])) {

    // form validation
    if (isset($_POST["info"])) {
        if (empty($_POST["info"])) {
            // $infoError = "<p>Please enter name or licence info.</p>";
        } else {
            $info = filter_input(INPUT_POST, "info", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // $infoError =  "<p>You searched for: " . $_POST["info"] . "</p>";
            // search people
            $people = queryPeople($db, $_POST["info"]);
            addAuditLog($db, $_SESSION['username'], "RETRIEVE", "searched for <strong>People</strong> with: '<strong>".$_POST["info"]."'</strong>");
        }
    }

    if (isset($_POST["showAllFlag"]) && $_POST["showAllFlag"] == '1') {
        $people = queryPeople($db, "");
        $_POST["showAllFlag"] = '0';
        addAuditLog($db, $_SESSION['username'], "RETRIEVE", "showed all <strong>People</strong>");
    }
    

    if (isset($_SESSION['addedPersonName'])) {

        $addNewPersonInfo = "<p>New person <strong>" . $_SESSION['addedPersonName'] . "</strong> added successfully.</p>";
        unset($_SESSION['addedPersonName']);
    } else {
        $addNewPersonInfo = "";
    }
} else {
    pleaseLogin();
}
?>


<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="query_people" id="query_people">
    <div class="form-group">

        <label for="ownerAutocomplete">Search People:</label>

        <div class="autocomplete">

            <input id="ownerAutocomplete" class="form-control" type="text" name="info" placeholder="Enter name or licence" style="display:inline;width:100%" onkeyup='filterTableByName("info", "searchPeople", ["People_name", "People_license"])'>

        </div>
        <div class="feedback-container" id="addNewPersonInfo" name="addNewPersonInfo"><?php echo $addNewPersonInfo; ?></div>

        <button type="submit" class="btn btn-primary">Search</button>

        <button type="button" class="btn btn-primary" name="showAllPeople" id="showAllPeople">Show all people</button>

        <input type="hidden" id="showAllFlag" name="showAllFlag" value="0">

        <button id="newOwnerButton" type="button" onclick="openNewOwnerForm()">New Person</button>

        <div class="invalid-feedback"><?php echo $infoError; ?></div>
    </div>
</form>


<script>
document.getElementById('showAllPeople').addEventListener('click', function() {
    document.getElementById('showAllFlag').value = '1';
    document.getElementById('query_people').submit();
});
</script>

<!-- table to show people info -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- <h2>Query Results:</h2> -->
            <?php if (empty($people)) : ?>
                <!-- <p>Please enter people's name or licences</p> -->
            <?php else : ?>
                <p>Found <?php echo count($people); ?> results.</p>
                <table class="table table-striped" id="searchPeople">
                    <thead>
                        <tr>
                            <th>People_ID</th>
                            <th>People_name</th>
                            <th>People_address</th>
                            <th>People_license</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($people as $person) { ?>
                            <tr>
                                <td><?php echo $person["People_ID"]; ?></td>
                                <td><?php echo $person["People_name"]; ?></td>
                                <td><?php echo $person["People_address"]; ?></td>
                                <td><?php echo $person["People_licence"]; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>


<!-- form to add new person -->
<div class="modal" id="newPerson">
    <span onclick="document.getElementById('modalForAddPersonID').style.display='none'" class="close" title="Close Modal">&times;</span>

    <form action="" method="post" class="modal-content" id="newPersonForm" name="newPersonForm">
        <div class="container">

            <h3>New Person</h3>

            <label for="personName"><b>personName </b><span style="color:red;">*</span></label>
            <input type="text" placeholder="Enter personName" id="personName">

            <label for="licenceNum"><b>licenceNum </b><span style="color:red;">*</span></label>
            <input type="text" placeholder="Enter licenceNum" id="licenceNum">

            <label for="personDOB"><b>Date of Birth</b></label>
            <input type="text" id="personDOB">

            <label for="penaltyPoints"><b>penaltyPoints</b></label>
            <input type="text" id="penaltyPoints">

            <label for="address"><b>address</b></label>
            <input type="text" id="address">

            <button id="newPersonInfo" type="submit" name="submit" class="btn">Confirm</button>
            <button id="closeNewOwnerButton" type="button" class="btn cancel" onclick="closeNewOwnerForm()">Cancel</button>
        </div>

    </form>
</div>


<?php include "inc/footer.php"; ?>