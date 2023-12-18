<!DOCTYPE html>
<html>

<head>
    <!-- <title>CW-2</title> -->
    <?php if (findTitle($_SERVER['PHP_SELF']) == "Index") : ?>
        <title><?php echo "Cousework 2"; ?></title>
    <?php else : ?>
        <title><?php echo findTitle($_SERVER['PHP_SELF']); ?></title>
    <?php endif; ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- <link rel="stylesheet" href="../css/mvp.css"> -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="/car.ico">

</head>

<body>

    <!-- sidenav bar -->
    <div class="sidenav">
        <div class="closebtn" onclick="closeNav()"><a href="javascript:void(0)">×</a></div>
        <div class="search" onkeyup="searchMenu()"><input type="text" id="mySearch" placeholder="Search" title="Type in a category"></div>
        <ul id="myMenu">
            <li data-page="index"><a href="index.php">Home</a></li>
            <li data-page="dashboard"><a href="dashboard.php">Dashboard</a></li>
            <!-- <li><a href="search_people.php"><i class="fa fa-fw fa-user"></i> People</a></li> -->
            <li data-page="search_people"><a href="search_people.php">People</a></li>

            <li data-page="search_vehicle"><a href="search_vehicle.php">Vehicle</a></li>
            <li data-page="add_vehicle"><a href="add_vehicle.php">Add Vehicle</a></li>
            <li data-page="report"><a href="report.php">Report</a></li>


            <?php
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'Administrator') {
            ?>
                <li data-page="fine"><a href="fine.php">Fine</a></li>
                <li data-page="add_police"><a href="add_police.php">Add Police User</a></li>
                <li data-page="audit_log"><a href="audit_log.php">Audit</a></li>

            <?php } else {
            } ?>

            <?php if (isset($_SESSION['username'])) { ?>
                <a href="logout.php" class="split">Logout</a>
            <?php } else { ?>
                <a href="login.php" class="split">Login</a>
            <?php } ?>
        </ul>
    </div>

    <main>
        <button class="openbtn" onclick="toggleNav()">☰</button>

        <!-- <h1>Coursework 2</h1> -->
        <?php if (findTitle($_SERVER['PHP_SELF']) == "Index") : ?>
            <h1><?php echo "Incidents Management system (IMS)"; ?></h1>
        <?php else : ?>
            <h1><?php echo findTitle($_SERVER['PHP_SELF']); ?></h1>
        <?php endif; ?>

        <?php if (isset($_SESSION['username'])) { ?>
            <p>Username: <strong> <?php echo "" . $_SESSION['username'] . "" ?></strong>. You can now operate. <a href='logout.php'>Logout</a></p>
        <?php } else { ?>
            <p>Please login first. <a href='login.php'>Login</a></p>
        <?php } ?>

        <?php require_once "inc/config.php"; ?>
        <hr>