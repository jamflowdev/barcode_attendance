<?php
  $qry = $conn->query("SELECT * FROM author") or die(msqli_error());
  $author = $qry->fetch_array();
?>
<!-- Footer -->
<footer class="page-footer text-white  bg-dark">
  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">
  <?php echo $author['copyright'] ?>
    <a href="<?php echo $author['description']; ?>"> <?php echo htmlentities($author['name']); ?></a>
  </div>
</footer>
<!-- Footer -->

