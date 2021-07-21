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
          <div class="col-md-6">
            <div class="form-group">
              <label>Nama Partai</label>
              <input required="required" type="text" class="form-control" name="nama_partai" value="" >
            </div>
          </div> 

          <div class="col-md-6">
            <div class="form-group">
              <label>Akronim</label>
              <input required="required" type="text" class="form-control" name="akronim" value="">
            </div>
          </div>    
        </div>

                  <div class="row mt-3">
                    <div class="col-md-6">
                          <div class="form-group">
                            <label>No. Urut</label>
                            <input type="text" maxlength="12" class="form-control input-default" id="telp" name="no_urutpartai" onkeypress="return isNumber(event)" value="" required="required"/>
                          </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                      <label>Tahun</label>
                      <div class="input-group">
                        <input name="tahun" type="text" class="form-control" id="tahun" required="">
                      </div>
                    </div>
                  </div>
                  </div>

                  <div class="row">
                      <div class="form-group">
                            <label>Lambang Partai :</label>
                            <div class="input-file input-file-image">
                              <img class="img-upload-preview" width="200" height="200" src="<?php echo base_url('assets/images/anti-avatar.png'); ?>" alt="preview">
                              <input type="file" class="form-control form-control-file" id="uploadImg" name="lambang" accept="image/*" required="" value="<?php echo base_url('assets/images/anti-avatar.png'); ?>">
                              <label for="uploadImg" class=" label-input-file btn btn-primary">Cari Gambar</label>
                            </div>
                      </div>
                      <div class="form-group" style="padding-top: 170px">
                        <p><b>Ketentuan Gambar:</b><br>- Dalam format .png atau .jpg <br>- Tidak lebih dari 2 Mb</p>
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