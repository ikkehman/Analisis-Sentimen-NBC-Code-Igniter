     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
 <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url('assets/css/ikkeh.css'); ?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url('assets/css/ready.min.css'); ?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url('assets/css/demo.css'); ?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url('assets/datepicker/dist/css/bootstrap-datepicker.css'); ?>" type="text/css" rel="stylesheet"/>

<script src="<?php echo base_url('assets/js/core/jquery.3.2.1.min.js'); ?>"></script>

<div class="row">
            <div class="wizard-container wizard-round col-md-7">
              <div class="wizard-header text-center">
                <h3 class="wizard-title"><b>Pendaftaran Peserta Baru</b></h3>
                <small>Harap isi dengan data sesuai KTP.</small>
              </div>
              <form role="form" enctype="multipart/form-data" class="largewidth" action="<?php echo base_url('register/submit'); ?>" method="post" novalidate="novalidate">
                <div class="wizard-body">
                  <div class="row">

                    <ul class="wizard-menu nav nav-pills nav-primary">
                      <li class="step" style="width: 33.3333%;">
                        <a class="nav-link" href="#about" data-toggle="tab" aria-expanded="true"><i class="la la-user"></i> Data Diri</a>
                      </li>
                      <li class="step" style="width: 33.3333%;">
                        <a class="nav-link" href="#account" data-toggle="tab"><i class="la la-file-o"></i> Informasi Akun</a>
                      </li>
                      <li class="step" style="width: 33.3333%;">
                        <a class="nav-link" href="#address" data-toggle="tab"><i class="la la-map-signs"></i> Alamat</a>
                      </li>
                    <div class="moving-tab" style="width: 269.083px; transform: translate3d(0px, 0px, 0px); transition: all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1);"><i class="la la-user"></i> Data Diri</div></ul>
                  </div>
                  <div class="tab-content">
                    <div class="tab-pane active" id="about">

            <?php if(validation_errors()): ?>
            <div class="col s12">
              <div class="card-panel red">
                <div class="alert alert-danger" role="alert"><span class="white-text"><?php echo validation_errors('<p>', '</p>'); ?></span></div>
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

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Nama :</label>
                            <input name="nama" type="text" class="form-control" required="">
                          </div>

                          <div class="form-group">
                            <label>Tempat Lahir :</label>
                            <input name="tempat_lahir" type="text" class="form-control" required="">
                          </div>

                          <div class="form-group">
                            <label for="exampleFormControlSelect1">Jenis Kelamin</label>
                            <select name="jk" required="" class="form-control">
                              <option disabled selected>-Pilih Kelamin-</option>
                              <option value="laki-laki">Laki-Laki</option>
                              <option value="perempuan">Perempuan</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label>No. Telepon/HP :</label>
                            <input type="text" maxlength="12" class="form-control input-default" id="telp" name="telp" onkeypress="return isNumber(event)" value="<?php echo set_value('telp'); ?>" required="required"/>
                          </div>

                          <div class="form-group">
                            <label>Tanggal Lahir :</label>
                            <div class="input-group">
                              <input name="tanggal_lahir" type="text" class="form-control" id="datepicker" name="datepicker" required="">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="exampleFormControlSelect1">Agama</label>
                            <select class="form-control" name="agama" required="">
                              <option disabled selected>-Pilih Agama-</option>
                              <option value="islam">Islam</option>
                              <option value="katolik">Katolik</option>
                              <option value="protestan">Protestan</option>
                              <option value="hindu">Hindu</option>
                              <option value="budha">Budha</option>
                              <option value="konghuchu">Konghuchu</option>
                            </select>
                          </div>
                        </div>

                      </div>
                      <div class="row">
                      <div class="form-group">
                            <label>Foto :</label>
                            <div class="input-file input-file-image">
                              <img class="img-upload-preview" width="200" height="200" src="<?php echo base_url('assets/images/noavatar.png'); ?>" alt="preview">
                              <input type="file" class="form-control form-control-file" id="uploadImg" name="avatar" accept="image/*" required="">
                              <label for="uploadImg" class=" label-input-file btn btn-primary">Upload Foto</label>
                            </div>
                      </div>
                      <div class="form-group" style="padding-top: 170px">
                        <p><b>Ketentuan Foto:</b><br>- Laki-laki latar merah <br>- Perempuan latar biru</p>
                      </div>
                      </div>

                    </div>
                    <div class="tab-pane" id="account">
                      <h4 class="info-text">Informasi untuk login ke sistem. </h4>
                      <div class="row">
                        <div class="col-md-8 ml-auto mr-auto">
                          <div class="form-group">
                            <label>Email :</label>
                            <input type="email" name="username" class="form-control" required="">
                          </div>
                          <div class="form-group">
                            <label>Password :</label>
                            <input type="password" id="password" name="password" class="form-control" required="">
                          </div>
                          <div class="form-group">
                            <label>Confirm Password :</label>
                            <input type="password" name="confirm_password" class="form-control" required="">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="address">
                      <h4 class="info-text">Masukan alamat asli anda.</h4>
                      <div class="row">
                        <div class="col-sm-8 ml-auto mr-auto">

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group select2-input">
                            <label for="exampleFormControlSelect1">Provinsi</label>
                            <select required="required" id="propinsi" onchange="loadKabupaten()" class="form-control">
                              <option value="" disabled selected>- Pilih Provinsi -</option>
                              <?php foreach ($propinsi->result() as $p) {echo "<option value='$p->id_provinsi'>$p->nama_prov</option>";}?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group select2-input">
                            <label for="exampleFormControlSelect1">Kabupaten/Kota</label>
                            <select required="required" name="kota" id="kabupatenArea" class="form-control">
                            <option disabled selected value="">- Pilih Kabupaten/Kota -</option>
                            </select>
                          </div>
                        </div>

                      </div>

                          <div class="form-group">
                            <label>Alamat</label>
                            
                            <textarea name="alamat" rows="3" class="form-control" required=""></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="wizard-action">
                  <div class="pull-left">
                    <input type="button" class="btn btn-previous btn-fill btn-default disabled" name="previous" value="Previous">
                  </div>
                  <div class="pull-right">
                    <input type="button" class="btn btn-next btn-danger" name="next" value="Next">
                    <button class="btn btn-finish btn-danger" type="submit" name="submit" value="login" style="display: none;">Register</button>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </form>
            </div>
          </div>







        <!-- JS  -->
<script src="<?php echo base_url('assets/js/core/jquery.3.2.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/core/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/core/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugin/jquery-mapael/jquery.mapael.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/ready.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/datepicker/dist/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/fileinput.js'); ?>"></script>
<script src="<?php echo base_url('assets/datepicker/dist/js/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugin/select2/select2.full.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugin/jquery.validate/jquery.validate.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugin/bootstrap-wizard/bootstrapwizard.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugin/moment/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugin/datepicker/bootstrap-datetimepicker.min.js'); ?>"></script>

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

<script type="text/javascript">
  $('#datepicker').datetimepicker({
  format: 'MM/DD/YYYY',
});
</script>

<script type="text/javascript">
  $('#propinsi').select2({
  theme: "bootstrap",
  width: '100%'
});
$('#kabupatenArea').select2({
  theme: "bootstrap",
  width: '100%'
});
</script>

<!--- Buat Dapat Provinsi -->
<script type="text/javascript">
    function loadKabupaten()
    {
        var propinsi = $("#propinsi").val();
        $.ajax({
            type:'GET',
            url:"<?php echo base_url(); ?>register/kabupaten",
            data:"id_provinsi=" + propinsi,
            success: function(html)
            { 
                $("#kabupatenArea").html(html);
            }
        }); 
    }
</script>