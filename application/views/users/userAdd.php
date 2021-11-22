<div class="container-fluid">
          <h4 class="page-title">User Profile</h4>
          <div class="row">

            <div class="col-md-10">
              <div class="card card-with-nav">
                <div class="card-header">
                  <div class="row">
                  </div>
                </div>

  <div class="tab-content">
          <?php if(validation_errors()): ?>
            <div class="col s12">
              <div class="card-panel red">
                <span class="white-text"><?php echo validation_errors('<p>', '</p>'); ?></span>
              </div>
            </div>
          <?php endif; ?>
          <?php if($message = $this->session->flashdata('message')): ?>
            <div class="col s12">
              <div class="card-panel <?php echo ($message['status']) ? 'green' : 'red'; ?>">
                <span class="white-text"><?php echo $message['message']; ?></span>
              </div>
            </div>
          <?php endif; ?>
    <div id="profil" class="tab-pane active">
                <div class="card-body">
              <form id="add-user-form" method="post" action="" enctype="multipart/form-data">
                  <div class="row mt-3">
                    <div class="col-md-6">
                          <div class="form-group">
                            <label>Nama :</label>
                            <input name="nama" type="text" class="form-control" required="" value="">
                          </div>
                    </div>
                    <div class="col-md-6">
                          <div class="form-group">
                            <label>Username :</label>
                            <input name="username" type="text" class="form-control" value="">
                          </div>
                    </div>
                  </div>

                   <div class="row mt-3">
                    <div class="col-md-6">
                          <div class="form-group">
                              <label>Password Baru</label>
                              <input required="required" name="password_baru" id="password_baru" type="password" class="form-control input-default">
                          </div>
                    </div>
                    <div class="col-md-6">
                          <div class="form-group">
                            <label>Ulangi Password</label>
                            <input required="required" name="konfirmasi_password" type="password" class="form-control input-default">
                          </div>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-6">
                          <div class="form-group">
                            <label for="exampleFormControlSelect1">Level</label>
                            <select name="level" required="" class="form-control">
                              <option disabled>-Pilih level-</option>
                              <option value="administrator">Administrator</option>
                              <option value="validator">Validator</option>
                            </select>
                          </div>
                    </div>


                  <div class="row mt-3">
                    <div class="row col-md-10">
                      <div class="form-group">
                            <label>Foto :</label>
                            <div class="input-file input-file-image">
                              <img class="img-upload-preview" width="150" height="150" src="<?php echo base_url('assets/images/noavatar.png'); ?>" alt="preview">
                              <input type="file" class="form-control form-control-file" id="uploadImg" name="avatar" accept="image/*">
                              <label for="uploadImg" class=" label-input-file btn btn-primary">Upload Foto</label>
                            </div>

                      </div>
                        <p style="padding-top: 35px"><b>Ketentuan Foto:</b><br>- Laki-laki latar merah <br>- Perempuan latar biru</p>
                    </div>
                  </div>

                  <div class="text-right mt-3 mb-3">
                    <button type="submit" name="submit" value="login" class="btn btn-success">Simpan</button>
                  </div>
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>
</div>
</div>
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