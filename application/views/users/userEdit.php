<div class="container-fluid">
          <h4 class="page-title">User Profile</h4>
          <div class="row">
            <div class="col-md-4">
              <div class="card card-profile card-secondary">
                <div class="card-header" style="background-image: url('<?php echo base_url()?>/assets/images/<?php echo $user->avatar; ?>')">
                  <div class="profile-picture">
                    <img src="<?php echo base_url()?>/assets/images/<?php echo $user->avatar; ?>" alt="Profile Picture">
                  </div>
                </div>
                <div class="card-body">
                  <div class="user-profile text-center">
                    <div class="name"><?php echo $user->nama; ?></div>
                    <div class="job"><?php echo $user->level; ?></div>
                    <div class="desc"><?php echo $user->username; ?></div>
                    <div class="view-profile">
                      <a href="<?php echo base_url()?>assets/images/<?php echo $user->avatar; ?>" target="_blank" class="btn btn-secondary btn-block">Lihat Foto Profil</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <div class="col-md-8">
              <div class="card card-with-nav">
                <div class="card-header">
                  <div class="row">
                    <ul class="nav nav-tabs nav-line nav-color-secondary" role="tablist">
                      <li class="nav-item submenu"> <a class="nav-link  active show" data-toggle="tab" href="#profil" role="tab" aria-selected="false">Profil</a> </li>
                      <li class="nav-item submenu"> <a class="nav-link" data-toggle="tab" href="#password" role="tab" aria-selected="true">Ganti Password</a> </li>
                    </ul>
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
                            <input name="nama" type="text" class="form-control" required="" value="<?php echo ucwords ($user->nama); ?>">
                          </div>
                    </div>
                    <div class="col-md-6">
                          <div class="form-group">
                            <label>Username :</label>
                            <input type="text" class="form-control" readonly value="<?php echo $user->username; ?>">
                          </div>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-6">
                          <div class="form-group select2-input">
                            <label for="exampleFormControlSelect1">Level</label>
                            <select name="level" required="" class="form-control">
                              <option disabled>-Pilih level-</option>
                              <option  selected value="<?php echo $user->level; ?>"><?php echo ucwords ($user->level); ?></option>
                              <option value="administrator">Administrator</option>
                              <option value="kpukabkot">KPU Kabupaten/Kota</option>
                            </select>
                          </div>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="row col-md-10">
                      <div class="form-group">
                            <label>Foto :</label>
                            <div class="input-file input-file-image">
                              <img class="img-upload-preview" width="150" height="150" src="<?php echo base_url()?>/assets/images/<?php echo $user->avatar; ?>" alt="preview">
                              <input type="file" class="form-control form-control-file" id="uploadImg" name="avatar" accept="image/*">
                              <label for="uploadImg" class=" label-input-file btn btn-primary">Upload Foto</label>
                            </div>

                      </div>
                    </div>
                  </div>

                  <div class="text-right mt-3 mb-3">
                    <button type="submit" name="submit" value="login" class="btn btn-success">Simpan</button>
                  </div>
                </form>
                </div>
              </div>

    <div id="password" class="tab-pane fade">
          <?php if($message = $this->session->flashdata('message')): ?>
            <div class="col s12">
              <div class="card-panel <?php echo ($message['status']) ? 'green' : 'red'; ?>">
                <span class="white-text"><?php echo $message['message']; ?></span>
              </div>
            </div>
          <?php endif; ?>
                <div class="card-body ikkeh">
              <form id="add-user-form" method="post" action="" enctype="multipart/form-data">
                  <div class="row mt-3">
                    <div class="col-md-6">
                          <div class="form-group">
                              <label>Password Baru</label>
                              <input required="required" id="password_baru" name="password_baru" type="password" class="form-control input-default">
                          </div>
                    </div>
                    <div class="col-md-6">
                          <div class="form-group">
                            <label>Ulangi Password</label>
                            <input required="required" name="konfirmasi_password" type="password" class="form-control input-default">
                          </div>
                    </div>
                  </div>

                  <div class="text-right mt-3 mb-3">
                    <button type="submit" name="submit-password" value="true" class="btn btn-success">Simpan</button>
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

  <script>
    // Code for the Validator
    var $validator = $('.wizard-container form').validate({
        rules: {
    confirm_password: {
      equalTo: "#password"
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
