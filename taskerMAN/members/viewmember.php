<?php
// if we are here not by the user selecting a task, then go back to main
//if(!((isset($_POST['memberSelect'])))){
//    header("Location: main.php");
//}

require_once("../components/dbconnect.php");

$lastNameError = "";
$firstNameError = "";
$memberEmailError = "";

// if we've just clicked on a member to view them, then populate fields with DB query
if (isset($_POST["memberSelect"])) {
    $sth = $conn->prepare("SELECT firstName, lastName, email FROM TeamMember WHERE email='" . str_replace('_', '.', array_keys($_POST)[1]) . "';");
    $sth->execute();
    $currMember = $sth->fetch(PDO::FETCH_ASSOC);
// else if we've just updated the user details, fill the fields with what was previously in them
}else if (isset($_POST["confirmMemberChanges"])) {
    require_once("../components/validators/validateMemberDetails.php");
    $currMember = ["lastName"=>$memberLastName, "firstName"=>$memberFirstName, "email"=>$memberEmail];
    if(!$error){ // $error is from the validateMemberDetails php
        //Validation Success!
        //Do form processing like email, database etc here

        try {
            if($memberLastNameDefault != $memberLastName) {
                $sql = "UPDATE TeamMember SET lastName='" . $memberLastName . "' WHERE email='" . $_POST["memberEmailDefault"] . "';";
                $sth = $conn->exec($sql);
            }

            if($memberFirstNameDefault != $memberFirstName) {
                $sql = "UPDATE TeamMember SET firstName='" . $memberFirstName . "' WHERE email='" . $_POST["memberEmailDefault"] . "';";
                $sth = $conn->exec($sql);
            }

            if ($_POST["memberEmailDefault"] != $_POST["memberEmail"]) {
                echo $_POST["memberEmail"];
                $sql = "INSERT INTO TeamMember VALUES ('$memberFirstName', '$memberLastName', '" . $_POST["memberEmail"] . "');";
                $sth = $conn->exec($sql);
                $sql = "UPDATE Task SET memberEmail='" . $_POST["memberEmail"] . "' WHERE memberEmail='" . $_POST["memberEmailDefault"] . "';";
                $sth = $conn->exec($sql);
                $sql = "DELETE FROM TeamMember WHERE email='" . $_POST["memberEmailDefault"] . "';";
                $sth = $conn->exec($sql);
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
} else if (isset($_POST['confirmMemberDelete'])) {
    $sql = "DELETE FROM TeamMember WHERE email='" . $_POST['memberEmail'] . "';";
    $conn->exec($sql);
    header("Location: ../actionsuccess.php");

} else if (isset($_POST['confirmMemberCancel'])) {
    header("Location: main.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>taskerMAN - View task</title>
    <link rel="stylesheet" href="../style.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic' rel='stylesheet' type='text/css'>
    <script>
        function checkValues(){

            var lastNameChanged = document.getElementById('memberLastNameDefault').value != document.getElementById('memberLastName').value;
            var firstNameChanged = document.getElementById('memberFirstNameDefault').value != document.getElementById('memberFirstName').value;
            var emailChanged = document.getElementById('memberEmailDefault').value != document.getElementById('memberEmail').value;

            if(lastNameChanged || firstNameChanged || emailChanged){
                document.getElementById("confirmMemberChanges").disabled = false;
            }else{
                document.getElementById("confirmMemberChanges").disabled = true;
            }
        }
    </script>
</head>
<body>

<?php
//require_once("../components/dbconnect.php");
require_once("../components/init.php");
loadInit("member", $conn);
//$sth = $conn->prepare("SELECT firstName, lastName, email FROM TeamMember WHERE email='" . str_replace('_', '.', array_keys($_POST)[1]) . "'");
//$sth->execute();
//$currMember = $sth->fetch(PDO::FETCH_ASSOC);
?>

<main>
    <div id="mainTop">
        <h2><?php
            if (isset($_POST["confirmTaskChanges"])) {
                echo $_POST["memberLastNameDefault"] . ", " . $_POST["memberFirstNameDefault"];
            }else{
                echo $currMember['lastName'] . ", " . $currMember['firstName'];
            }
            ?>
        </h2>
    </div>
    <div id="mainBody">
        <form id="viewMemberForm" name="viewMemberForm" action="?" method="POST"">
            <fieldset>
                <label for="memberLastName">Last name</label>
                <input type="hidden" id="memberLastNameDefault" name="memberLastNameDefault" value='<?php echo $currMember["lastName"] ?>' />
                <input type="text" id="memberLastName" name="memberLastName" max="64" value="<?php echo $currMember['lastName'] ?>" onchange="checkValues()" />
                <span class='error'><?php echo $memberLastNameError ?></span>
                <br />
                <label for="memberFirstName">First name</label>
                <input type="hidden" id="memberFirstNameDefault" name="memberFirstNameDefault" value="<?php echo $currMember['firstName'] ?>" />
                <input type="text" id="memberFirstName" name="memberFirstName" max="64" value="<?php echo $currMember['firstName'] ?>" onchange="checkValues()" />
                <span class='error'><?php echo $memberFirstNameError ?></span>
                <br />
                <label for="memberEmail">Email</label>
                <input type="hidden" id="memberEmailDefault" name="memberEmailDefault" value="<?php echo $currMember['email'] ?>" />
                <input type="text" id="memberEmail" name="memberEmail" max="64" value="<?php echo $currMember['email'] ?>" onchange="checkValues()" />
                <span class='error'><?php echo $memberEmailError ?></span>
                <br />
                <hr />
                <input type="submit" id="confirmMemberChanges" name="confirmMemberChanges" value="Confirm changes" disabled />
                <input type="submit" id="confirmMemberDelete" name="confirmMemberDelete" value="Delete member" onclick="return confirm('Are you sure you wish to delete this member? Click \'OK\' to confirm or \'Cancel\' to abort.');"/>
                <input type="submit" name="confirmMemberCancel" value="Cancel" />
            </fieldset>
        </form>
    </div>
    <div id="mainRight">

    </div>
</main>

</body>
</html>