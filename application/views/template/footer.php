<!--   Core JS Files   -->
  <script src="<?php echo base_url('assets/js/core/jquery.3.2.1.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/core/popper.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/core/bootstrap.min.js'); ?>"></script>

  <!-- jQuery UI -->
  <script src="<?php echo base_url('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js'); ?>"></script>

  <!-- jQuery Scrollbar -->
  <script src="<?php echo base_url('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js'); ?>"></script>

  <!-- Moment JS -->
  <script src="<?php echo base_url('assets/js/plugin/moment/moment-with-locales.min.js'); ?>"></script>

  <!-- Chart JS -->
  <script src="<?php echo base_url('assets/js/plugin/chart.js/chart.min.js'); ?>"></script>

  <!-- Chart Circle -->
  <script src="<?php echo base_url('assets/js/plugin/chart-circle/circles.min.js'); ?>"></script>

  <!-- Datatables -->
  <script src="<?php echo base_url('assets/js/plugin/datatables/datatables.min.js'); ?>"></script>

  <!-- Bootstrap Notify -->
  <script src="<?php echo base_url('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js'); ?>"></script>

  <!-- Bootstrap Toggle -->
  <script src="<?php echo base_url('assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js'); ?>"></script>

  <!-- jQuery Vector Maps -->
  <script src="<?php echo base_url('assets/js/plugin/jqvmap/jquery.vmap.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/plugin/jqvmap/maps/jquery.vmap.world.js'); ?>"></script>

  <!-- Google Maps Plugin -->
  <script src="<?php echo base_url('assets/js/plugin/gmaps/gmaps.js'); ?>"></script>

  <!-- Dropzone -->
  <script src="<?php echo base_url('assets/js/plugin/dropzone/dropzone.min.js'); ?>"></script>

  <!-- Fullcalendar -->
  <script src="<?php echo base_url('assets/js/plugin/fullcalendar/fullcalendar.min.js'); ?>"></script>

  <!-- DateTimePicker -->
  <script src="<?php echo base_url('assets/js/plugin/datepicker/bootstrap-datetimepicker.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/datepicker/dist/js/bootstrap-datepicker.js'); ?>"></script>

  <!-- Bootstrap Tagsinput -->
  <script src="<?php echo base_url('assets/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js'); ?>"></script>

  <!-- Bootstrap Wizard -->
  <script src="<?php echo base_url('assets/js/plugin/bootstrap-wizard/bootstrapwizard.js'); ?>"></script>

  <!-- jQuery Validation -->
  <script src="<?php echo base_url('assets/js/plugin/jquery.validate/jquery.validate.min.js'); ?>"></script>

  <!-- Summernote -->
  <script src="<?php echo base_url('assets/js/plugin/summernote/summernote-bs4.min.js'); ?>"></script>

  <!-- Select2 -->
  <script src="<?php echo base_url('assets/js/plugin/select2/select2.full.min.js'); ?>"></script>

  <!-- Sweet Alert -->
  <script src="<?php echo base_url('assets/js/plugin/sweetalert/sweetalert.min.js'); ?>"></script>

  <!-- Ready Pro JS -->
  <script src="<?php echo base_url('assets/js/ready.min.js'); ?>"></script>
  	</body>
</html>

<script type="text/javascript">
  $('#datepicker').datepicker({
  format: 'dd MM yyyy',
  autoclose: 'true',
});
</script>

<script>
    // Code for the Validator
    var $validator = $('.container-fluid form').validate({
        rules: {
    konfirmasi_password: {
      equalTo: "#password_baru"
    }
  },
      validClass : "success",
      highlight: function(element) {
        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
      },
      success: function(element) {
        $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
      }
    });
  </script>

  <script type="text/javascript">
  $('#dataset').select2({
  theme: "bootstrap",
  width: '100%'
});

</script>

<script>
    // Code for the Validator
    var $validator = $('.ikkeh form').validate({
        rules: {
    konfirmasi_password: {
      equalTo: "#password_baru"
    }
  },
      validClass : "success",
      highlight: function(element) {
        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
      },
      success: function(element) {
        $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
      }
    });
  </script>

  <script type="text/javascript">
    jQuery(document).ready(function(){
    jQuery('.scrollbar-inner').scrollbar();
});
  </script>