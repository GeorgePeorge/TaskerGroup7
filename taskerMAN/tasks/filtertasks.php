<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN - Filter tasks</title>
    <link rel="stylesheet" href="../style.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic' rel='stylesheet' type='text/css'>
</head>
<body>

<?php
require_once("../components/dbconnect.php");
require_once("../components/init.php");
if (isset($_POST["filterTaskSubmit"])){
    if ($_POST["filterTaskSubmit"] == "Submit"){
        loadInit("task", $conn, [$_POST["taskStatusFilter"], $_POST["taskTeamMemberFilter"]]);
    }else{
        header("Location: ../index.php");
    }
}else{
    loadInit("task", $conn);
}

?>

<main>
    <div id="mainTop">
        <h2>Filter tasks</h2>
    </div>
    <div id="mainBody">
        <form id="filterTasksForm" name="filterTasksForm" action="" method="POST">
            <fieldset>
                <legend>Filter by</legend>
                <label for="taskStatusFilter">Task status</label>
                <label for="taskTeamMemberFilter">Allocated team member</label>
                <br />
                <select name="taskStatusFilter" id="taskStatusFilter" onchange="checkDropdown()">
                    <option value="any">any</option>
                    <option value="allocated">allocated</option>
                    <option value="abandoned">abandoned</option>
                    <option value="completed">completed</option>
                </select>
                <select name="taskTeamMemberFilter" id="taskTeamMemberFilter">
                    <option value="any">any</option>
                    <?php
                    $query = "SELECT lastName, firstName, email FROM TeamMember";
                    foreach($conn->query($query) as $row){
                      echo "<option value='" . $row['email'] . "'>" . $row['lastName'] . ", " . $row['firstName'] . " (" . $row['email'] . ")</option>";
                    }
                    ?>
                    <?php require_once("../components/populateDropDown.php"); ?>
                </select>
                <br />
                <hr />
                <input type="submit" name="filterTaskSubmit" value="Submit" />
                <input type="submit" name="filterTaskSubmit" value="Cancel" />
            </fieldset>
        </form>
    </div>
</main>

</body>
</html>