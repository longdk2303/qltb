</div>
</div>
<!-- [ Main Content ] end -->
<footer class="pc-footer">
  <div class="footer-wrapper container-fluid">
    <div class="row">
      <div class="col my-1">
        <p class="m-0">Copyright &copy; 2024</a></p>
      </div>
      <div class="col-auto my-1">
        <ul class="list-inline footer-link mb-0">
          <li class="list-inline-item"><a href="<?= BASE_URL("/") ?>">Home</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>

<!-- [Page Specific JS] start -->
<script src="<?= BASE_URL("/assets/client/js/plugins/apexcharts.min.js") ?>"></script>
<!-- [Page Specific JS] end -->
<?= $script ?>
<!-- Required Js -->
<script src="<?= BASE_URL("/assets/client/js/plugins/popper.min.js") ?>"></script>
<script src="<?= BASE_URL("/assets/client/js/plugins/simplebar.min.js") ?>"></script>
<script src="<?= BASE_URL("/assets/client/js/plugins/bootstrap.min.js") ?>"></script>
<script src="<?= BASE_URL("/assets/client/js/fonts/custom-font.js") ?>"></script>
<script src="<?= BASE_URL("/assets/client/js/pcoded.js") ?>"></script>
<script src="<?= BASE_URL("/assets/client/js/plugins/feather.min.js") ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@latest"></script>

<script>
  layout_change('light');
</script>

<script>
  layout_theme_contrast_change('false');
</script>

<script>
  change_box_container('false');
</script>

<script>
  layout_caption_change('true');
</script>

<script>
  layout_rtl_change('false');
</script>

<script>
  preset_change("preset-1");
</script>

</body>
<!-- [Body] end -->

</html>