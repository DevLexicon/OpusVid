<?php
/* db_feedbacks.php | Version 1.0
  By: OpusVid
  User Level Required: 0+

  This file submits the feedback

  Blades Incuded:
    #db_connect: To connect to Database
    #emails/email_feedback.php: Sends email

  File used in:
    #feedback
*/

require 'db_connect.php'; //Connects to the database

//Gets the inputs from the submitted form fields
$issue = mysqli_real_escape_string($mySQL, nl2br($_POST['issueRun']));
$journy = mysqli_real_escape_string($mySQL, $_POST['betaJourny']);

//If yes for a beta journy was selected then get all selected tasks
if ($journy === "yes") {
  $taskSelected = "";
  $taskSelect = $_POST['taskSelect'];
  foreach ($taskSelect  as $value) {
      $taskSelected .= $value." / "; // Add "/" to all selected tasks
  }
}

$tasksYes = mysqli_real_escape_string($mySQL, nl2br($_POST['betaTaskYES']));
$tasks = mysqli_real_escape_string($mySQL, nl2br($_POST['betaTask']));
$experince = mysqli_real_escape_string($mySQL, nl2br($_POST['betaExperince']));
$process = mysqli_real_escape_string($mySQL, nl2br($_POST['betaProcess']));
$design = mysqli_real_escape_string($mySQL, nl2br($_POST['betaDesign']));
$user = mysqli_real_escape_string($mySQL, nl2br($_POST['betaUser']));
$overall = mysqli_real_escape_string($mySQL, nl2br($_POST['betaOverall']));
$other = mysqli_real_escape_string($mySQL, nl2br($_POST['other']));

$sqlInsert = "INSERT INTO feedback (issues, bJourny, tasks, tasksYes, tasksCompleted, experience, process, design, navigation, overall, addComments) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$insertStmt = mysqli_stmt_init($mySQL);
if (!mysqli_stmt_prepare($insertStmt, $sqlInsert)){ //If the sql statement failed to load redirect user
  header("Location: ../feedback?submit=false&i=$issue&j=$journy&ts=$taskSelected&ty=$tasksYes&t=$tasks&e=$experince&p=$process&d=$design&u=$user&ov=$overall&ot=$other");
  exit();
} else { //Bind the form data to the database
  mysqli_stmt_bind_param($insertStmt, "sssssssssss", $issue, $journy, $taskSelected, $tasksYes, $tasks, $experince, $process, $design, $user, $overall, $other);
  mysqli_stmt_execute($insertStmt);
}
header("Location: ../feedback?submit=true");

include 'emails/email_feedback.php'; //Send feedback in email
