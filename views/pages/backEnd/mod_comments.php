<?php  
  require '../../blades/portalHeaderMod.php'; 
  $commentClass = new Comments;
?>

<body>
  <script> document.title = "Comment Manager | <?php echo $websiteName; ?>"</script>
  <?php require '../../blades/portalHeader.php'; ?> 
  <?php require '../../blades/errors.php'; ?>
    <section id="manageVideo" class="">
      <h3><span class="underline pageTitle">Moderation: Comment Manager</span></h3>
        <div id="manageVideoWrap">
          <?php echo $videoFeed = $commentClass->manageCommentsMod(); ?>
        </div> <!-- #manageVideoWrap -->
    </section> <!-- #manageVideo -->
  </main>
  </div> <!-- .portalContent -->
<?php require '../../blades/footer.php'; ?>