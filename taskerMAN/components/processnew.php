<?php

if ($conn == null){
    header("Location: ../dberror.php");
}

//if(isset($_GET['taskTitle']) || isset($_GET['memberFirstName'])){
if ($_POST['confirmTaskChanges'] == "Cancel") {
    header("Location: ../index.php");
}

// if we've come from the new task page
if (isset($_POST['taskTitle'])) {

    $sDate = implode("", explode("-", $_GET['startDate']));
    $ecdDate = implode("", explode("-", $_GET['completionDate']));

    //echo $_GET['taskTitle'] . $sDate . $ecdDate . $_GET['teamMember'];
    //header("Location: ../tasks/main.php");
//    try {
//        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//        // set the PDO error mode to exception
//        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);




        echo $sql;

        // Prepare statement
        //$stmt = $conn->prepare($sql);

        // execute the query
        //$stmt->execute();

        // echo a message to say the UPDATE succeeded
        //echo $stmt->rowCount() . " records UPDATED successfully";
//    } catch (PDOException $e) {
//        echo $sql . "<br>" . $e->getMessage();
//    }
    //header("Location: ../index.php");
}

if (isset($_GET['newMemberForm'])) { // if we've come from making a new member
    $sql = "INSERT INTO TeamMember VALUES ('$memberLastName', '$memberFirstName', '$memberEmail');";
    $sth = $conn->query($sql);
}else if (isset($_GET['newTaskForm'])) { // if we've come from making a new task
    $sql = "INSERT INTO Task (title, startDate, ecd, memberEmail) VALUES ($taskTitle, $sDate, $ecdDate, " . $_POST['teamMember'] . ")";
    $sth = $conn->query($sql);
}
?>