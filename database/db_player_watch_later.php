<?php
/* db_player_watch_later.php | Version 1.0
  By: OpusVid
  User Level Required: 0+

  This file is used to make the watch later view page function!

  Blades Included:
    #db_connect: To connect to Database

  File used in:
    #watch_later?id=*
*/

require 'db_connect.php';

//Gets the video ID
  $profile = $_SESSION['uName'];
  $currentVidID = $_GET['vid'];
  $currentIndex = $_GET['index'];

//Gets the video information
  $collectionSQL = "SELECT * FROM watch_later WHERE user = '" . mysqli_escape_string($mySQL, $profile) . "';";
  $resultCollection = mysqli_query($mySQL, $collectionSQL);
  $collection = mysqli_fetch_assoc($resultCollection);

  $selectSQL = "SELECT videos FROM watch_later WHERE user = '" . mysqli_escape_string($mySQL, $profile) . "';";
  $selectResult = mysqli_query($mySQL, $selectSQL);
  $selectRow = mysqli_fetch_assoc($selectResult);
  $selectCount = mysqli_num_rows($selectResult);
  $videosAlreadyAdded = explode(' / ', $selectRow['videos'], -1); //Separates each video ID in the array into their own array

  $videoNumber = sizeof($videosAlreadyAdded); //Gets the number of videos in list

  $playerID = $videosAlreadyAdded[$currentIndex];

  $currentVidSQL = "SELECT * FROM videos WHERE id = '$playerID'";
  $currentVidResults = mysqli_query($mySQL, $currentVidSQL);
  $video = mysqli_fetch_assoc($currentVidResults);

  $pathID = implode("' OR id = '", $videosAlreadyAdded); //Takes all the video IDs and adds "OR id =" to it for getting information from the database
  $pathSQL = "SELECT video_path FROM videos WHERE id = '$pathID'";
  $pathResults = mysqli_query($mySQL, $pathSQL);
  $pathFetch = mysqli_fetch_all($pathResults);

  $userID = $video['opus_creator'];
  $userSelect = "SELECT * FROM users WHERE username = '" . mysqli_escape_string($mySQL, $userID) . "';";
  $userResults = mysqli_query($mySQL, $userSelect);
  $user = mysqli_fetch_assoc($userResults);

  $following = $userID;
  include 'db_templates/follow.php'; //Follow function: By User ID
