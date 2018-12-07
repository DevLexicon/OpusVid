<?php
/* db_editV.php | Version 1.0
  By: OpusVid
  User Level Required: 0+

  The file is to edit a video and its information

  Blades Included:
    #db_connect: To connect to Database
    #db_templates/thumbnailFile: Get's the file information for thumbnails
    #../do_spaces/spaces_config: Connects to DigitalOcean for upload prep
    #../do_spaces/spaces_thumbUpload: Uploads new thumbnail

  File used in:
    #dashboard/edit?id=*
    #admin/edit_video?id=*
*/

if (isset($_POST['submit'])) { //Looks to see if the form has been submitted #FormSubmitted
  require 'db_connect.php'; //Connects to database

  $uniqeID = mysqli_real_escape_string($mySQL, $_POST['vidID']); //Gets the video id from the post

  include 'db_templates/thumbnailFile.php'; //Get's all the file information for thumbnails
  include '../do_spaces/spaces_config.php'; //Connects to DO Spaces

  //Gets information from the submitted form
  $uploadTitle = mysqli_real_escape_string($mySQL, $_POST['vTitle']);
  $opusCreator = mysqli_real_escape_string($mySQL, $_POST['by']);
  $uploadSDescription = mysqli_real_escape_string($mySQL, nl2br($_POST['sDescription']));
  $uploadDescription = mysqli_real_escape_string($mySQL, nl2br($_POST['description']));
  $uploadCategory = mysqli_real_escape_string($mySQL, $_POST['category']);
  $uploadTags = mysqli_real_escape_string($mySQL, nl2br($_POST['tags']));
  $uploadMusicCredit = mysqli_real_escape_string($mySQL, nl2br($_POST['musicCredit']));
  $uploadFilmedBy = mysqli_real_escape_string($mySQL, $_POST['filmedBy']);
  $uploadFilmedWith = mysqli_real_escape_string($mySQL, $_POST['filmedWith']);
  $uploadFilmedAt = mysqli_real_escape_string($mySQL, $_POST['filmedAt']);
  $uploadFilmedOn = mysqli_real_escape_string($mySQL, $_POST['filmedOn']);
  $uploadAudioBy = mysqli_real_escape_string($mySQL, $_POST['audioBy']);
  $uploadAudioWith = mysqli_real_escape_string($mySQL, $_POST['audioWith']);
  $uploadEditedBy = mysqli_real_escape_string($mySQL, $_POST['editedBy']);
  $uploadEditedOn = mysqli_real_escape_string($mySQL, $_POST['editedOn']);
  $uploadStaring = mysqli_real_escape_string($mySQL, nl2br($_POST['staring']));
  $uploadPrivacy = mysqli_real_escape_string($mySQL, $_POST['privacy']);

  $error =0; // Sets initial error number to 0 meaning no errors

  $updateSQL = "UPDATE videos SET video_title = '$uploadTitle', opus_creator = '$opusCreator', short_description = '$uploadSDescription', description = '$uploadDescription', category = '$uploadCategory', tags = '$uploadTags', music_credit = '$uploadMusicCredit', filmed_date = '$uploadFilmedOn', filmed_at = '$uploadFilmedAt', filmed_on = '$uploadFilmedWith', filmed_by = '$uploadFilmedBy', audio_by = '$uploadAudioBy', audio_with = '$uploadAudioWith', edited_by = '$uploadEditedBy', edited_on = '$uploadEditedOn', staring = '$uploadStaring', privacy = '$uploadPrivacy' WHERE id= '$uniqeID';";
  $results = mysqli_query($mySQL, $updateSQL); //Updates video information

  if (!$thumbTemp) { //If NO thumbnail was uploaded then it will redirect the user to the video manager: Video Edit Success Message #NoThumb
    header("Location: ../dashboard/manage?edited=success");
    exit(); //And then end the php script
  } //End: NoThumb
  elseif (in_array($thumbExtention, $thumbExtAllow) != $thumbExtention) {
      $error = 1; //Error reached
      header("Location: ../dashboard/edit?id=$uniqeID&setting=ext&error=1");
    } //extention check
    elseif ($thumbError != 0) {
      $error = 2;
      header("Location: ../dashboard/edit?id=$uniqeID&setting=error&error=2");
    } //error check
    elseif ($thumbSize > 5368709120) {
      $error = 3;
      header("Location: ../dashboard/edit?id=$uniqeID&setting=big&error=3");
    } //size check
  } //End: FormSubmitted
  if($error == 0) { //If no errors with uploading thumbnail then upload it! #ThumbUpload
    include '../do_spaces/spaces_thumbUpload.php';

    $path = "https://opusvid.sfo2.cdn.digitaloceanspaces.com/thumbnails/".$uniqeID.".".$thumbExtention;

    $updateThumbSQL = "UPDATE videos SET thumbnail_path = '$path' WHERE id= '$uniqeID';";

    $resultsThumb = mysqli_query($mySQL, $updateThumbSQL);
  } //End: ThumbUpload

  header("Location: ../dashboard/manage?edited=success"); //Once uploaded redirect to video manger: Video Edit Success Message
