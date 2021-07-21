    <div class="card col-10">
    <div class="card-header">
                      <div class="card-title"><?php echo $pageTitle; ?></div>
                    </div>
      <div class="card-content">
        <form id="add-user-form" method="post" action="" enctype="multipart/form-data">
          <?php if(validation_errors()): ?>
            <div class="col s12">
              <div class="card-panel red">
                <span class="white-text"><?php echo validation_errors('<p>', '</p>'); ?></span>
              </div>
            </div>
          <?php endif; ?>
          <?php if($message = $this->session->flashdata('message')): ?>
            <div class="col s12">
              <div class="alert <?php echo ($message['status']) ? 'alert-success' : 'alert-danger'; ?>">
                <span class="white-text"><?php echo $message['message']; ?></span>
              </div>
            </div>
          <?php endif; ?>

        <div class="row mt-3">
          <div class="col-md-12">
            <div class="form-group">
              <label>Nama Dokumen</label>
              <input required="required" type="text" class="form-control" name="nama_docs" value="" >
            </div>
          </div>  
        </div>

                  <div class="row mt-3">
                    <div class="col-md-6">
                          <div class="form-group">
                            <label>Kategori</label>
                            <select name="kategori" required="" class="form-control">
                              <option disabled selected>-Pilih Kategori-</option>
                              <option value="pilkada">Pilkada</option>
                              <option value="pileg">Pileg</option>
                              <option value="pilpres">Pilpres</option>
                              <option value="peraturan pemilu">Peraturan Pemilu</option>
                              <option value="dokumen lain">Dokumen lain</option>
                            </select>
                          </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                      <label>Tahun</label>
                      <div class="input-group">
                        <input name="tahun_docs" type="text" class="form-control" id="tahun" required="">
                      </div>
                    </div>
                  </div>
                  </div>

      <div class="col-md-6">
                          <div class="form-group">
                            <label>Upload file</label>
                              <input type="file" name="file"></input><br />
                          </div>
                    </div>

        <div class="row" style="padding-bottom: 20px;">
              <button type="submit" name="submit" value="login" class="btn btn-success">Simpan</button>
          </div>

        </form>
      </div>
    </div>


<script src="<?php echo base_url('assets/js/core/jquery.3.2.1.min.js'); ?>"></script>
<script>

  $(document).ready(function(){
        $('#basic').select2({
    theme: "bootstrap"
  });

  $('#multiple').select2({
    theme: "bootstrap"
  });

    $("#tahun").datepicker({
    format: "yyyy",
    viewMode: "years", 
    minViewMode: "years",
    autoclose: 'true',
});

    });
</script>

  <!--- Buat Dapat Nomor HP -->
<script type="text/javascript">     
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ( (charCode > 31 && charCode < 48) || charCode > 57) {
        return false;
    }
        return true;
}
</script>