<?php
/* db_vid_feed_follow.php | Version 1.0
  By: OpusVid
  User Level Required: 0+

  The file is to get all public videos from the Opus Creators in which you follow; and display their information

  Blades Included:
    #db_connect: To connect to Database
    #pagination_init: Initiate the pagination
    #pagination_control: Controls the control of the pagination
    #db_templates/foreach_player.php: Adds the information for a "foreach" loop

  File used in:
    #home -> index
*/

if (isset($_SESSION['uID'])) { //If form is submitted #FormSubmitted
  include 'db_connect.php';

  //Find out how many items are in the videos table
  $countSQL = "SELECT COUNT(order_number) FROM videos WHERE privacy='public'";
  $query = mysqli_query($mySQL, $countSQL);
  $row = mysqli_fetch_row($query);
  $rows = $row[0];

  //Number of items to display per page
  $per_page = 16;

  include '../../page-templates/pagination_init.php';

  $userID = $_SESSION['uID'];
  $searchSQL = "SELECT * FROM following WHERE follower_id = '$userID'";
  $searchResult = mysqli_query($mySQL, $searchSQL);
  $searchRow = mysqli_fetch_assoc($searchResult);

  $explode = explode(" / ", $searchRow['following_id']); //Separates each followed ID in the array into their own array

  $usersIDFollowing = implode(" OR id =",$explode); //Takes all the followed IDs and adds "OR id =" to it for getting information from the database

  $followSQL = "SELECT * FROM users WHERE id=$usersIDFollowing";
  $followResults = mysqli_query($mySQL, $followSQL);

  include 'db_templates/foreach_follow.php';

  $users = mysqli_fetch_all($followResults);

  $followSQL1 = "SELECT username FROM users WHERE id=$usersIDFollowing";
  $followResults1 = mysqli_query($mySQL, $followSQL1);
  $users = mysqli_fetch_all($followResults1);

  $usernameImplose = implode("' OR opus_creator = '", array_column($users, 0)); //Takes all the followed IDs and adds "OR id =" to it for getting information from the database

  $videoSelect = "SELECT * FROM videos WHERE opus_creator = '$usernameImplose' AND privacy='public' ORDER BY order_number DESC $limit";
  $resultPlayer = mysqli_query($mySQL, $videoSelect);

  include '../../page-templates/pagination_control.php';
  include 'db_templates/foreach_player.php';

} //End: FormSubmitted
else { //If form has not been submitted redirect to the home page #Error
  header("Location: home");
} //End: Error
