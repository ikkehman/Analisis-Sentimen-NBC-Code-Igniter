<div class="row">
            <div class="wizard-container wizard-round col-md-8">
              <div class="wizard-header text-center">
                <h3 class="wizard-title"><b>Informasi Caleg</b></h3>
              </div>
              <form role="form" enctype="multipart/form-data" class="largewidth" action="" method="post" novalidate="novalidate">
                <div class="wizard-body">
                  <div class="row">

                    <ul class="wizard-menu nav nav-pills nav-primary">
                      <li class="step" style="width: 33.3333%;">
                        <a class="nav-link" href="#about" data-toggle="tab" aria-expanded="true"><i class="la la-user"></i> Data Diri</a>
                      </li>
                      <li class="step" style="width: 33.3333%;">
                        <a class="nav-link" href="#account" data-toggle="tab"><i class="la la-file-o"></i> Informasi Partai</a>
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
              <div class="card-panel alert <?php echo ($message['status']) ? 'alert-success' : 'alert-danger'; ?>">
                <span class="white-text"><?php echo $message['message']; ?></span>
              </div>
            </div>
          <?php endif; ?>

                      
                          <div class="form-group">
                            <label>Nama :</label>
                            <input name="nama" type="text" class="form-control" required="" value="<?php echo $caleg->nama; ?>">
                          </div>

                        <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Tempat Lahir :</label>
                            <input name="tp_lahir" type="text" class="form-control" required="" value="<?php echo $caleg->tp_lahir; ?>">
                          </div>

                          <div class="form-group">
                            <label for="exampleFormControlSelect1">Jenis Kelamin</label>
                            <select name="jk" class="form-control">
                              <option value="<?php echo $caleg->jk; ?>" selected><?php echo ucwords($caleg->jk); ?></option>
                              <option value="laki laki">Laki-Laki</option>
                              <option value="perempuan">Perempuan</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="exampleFormControlSelect1">Status Pernikahan</label>
                            <select name="status_kawin" required="" class="form-control">
                              <option value="<?php echo $caleg->status_kawin; ?>" selected><?php echo ucwords($caleg->status_kawin); ?></option>
                              <option value="belum menikah">Belum Menikah</option>
                              <option value="menikah">Menikah</option>
                              <option value="pernah menikah">Pernah Menikah</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Tanggal Lahir :</label>
                            <div class="input-group">
                              <input name="tg_lahir" type="text" class="form-control" id="datepicker" name="datepicker" required="" value="<?php echo $caleg->tg_lahir; ?>">
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="exampleFormControlSelect1">Agama</label>
                            <select class="form-control" name="agama" required="">
                              <option value="<?php echo $caleg->agama; ?>" selected><?php echo ucwords($caleg->agama); ?></option>
                              <option value="islam">Islam</option>
                              <option value="katolik">Katolik</option>
                              <option value="protestan">Protestan</option>
                              <option value="hindu">Hindu</option>
                              <option value="budha">Budha</option>
                              <option value="konghuchu">Konghuchu</option>
                            </select>
                          </div>

                          <div class="form-group">
                            <label>Pendidikan Terakhir</label>
                            <div class="input-group">
                              <input name="pend" type="text" class="form-control" required="" value="<?php echo $caleg->pend; ?>">
                            </div>
                          </div>
                        </div>
                      </div>

                        <div class="form-group">
                          <label>Alamat</label>
                          <textarea class="form-control" name="alamat" rows="3"><?php echo $caleg->alamat; ?></textarea>
                        </div>

                      <div class="row">
                      <div class="form-group">
                            <label>Foto :</label>
                            <div class="input-file input-file-image">
                              <img class="img-upload-preview" width="200" height="200" src="<?php echo base_url('assets/images/'.$caleg->foto_caleg); ?>" alt="preview">
                              <input type="file" class="form-control form-control-file" id="uploadImg" name="foto_caleg" accept="image/*">
                              <label for="uploadImg" class=" label-input-file btn btn-primary">Upload Foto</label>
                            </div>
                      </div>
                      <div class="form-group" style="padding-top: 170px">
                        <p><b>Ketentuan Foto:</b><br>- Tidak lebih dari 2 MB
                      </div>
                      </div>

                    </div>
                    <div class="tab-pane" id="account">
                      <h4 class="info-text">Informasi Partai Calon Legislatif </h4>
                      <div class="row">
                        <div class="col-md-8 ml-auto mr-auto">
                          <div class="form-group select2-input">
                            <label for="exampleFormControlSelect1">Partai</label>
                            <select required="required" id="pendaftar" name="id_partai" class="form-control">
                              <option value="<?php echo $caleg->id_partai; ?>" selected><?php echo $caleg->nama_partai; ?></option>
                              <?php foreach ($partai->result() as $p) {echo "<option value='$p->id_partai'>$p->no_urutpartai - $p->nama_partai</option>";}?>
                            </select>
                          </div>

                          <div class="form-group">
                            <label>No. Urut</label>
                            <input type="text" maxlength="12" class="form-control input-default" id="telp" name="no_urutcal" onkeypress="return isNumber(event)" value="<?php echo $caleg->no_urutcal; ?>" required="required"/>
                          </div>

                          <div class="form-group select2-input">
                            <label for="exampleFormControlSelect1">Dapil</label>
                            <select required="required" id="dapil" name="dapil" class="form-control">
                              <option value="<?php echo $caleg->dapil; ?>" selected><?php echo $caleg->nama_dapil; ?></option>
                              <?php foreach ($dapil->result() as $d) {echo "<option value='$d->id_dapil'>$d->nama_dapil</option>";}?>
                            </select>
                          </div>                          

                            <div class="form-group">
                              <label>Tahun</label>
                              <div class="input-group">
                                <input name="tahun_caleg" type="text" class="form-control" id="tahun" required="required" value="<?php echo $caleg->tahun_caleg; ?>">
                              </div>
                            </div>

                          <div class="form-group">
                          <label>Motivasi</label>
                          <textarea class="form-control" name="motivasi" rows="3"><?php echo $caleg->motivasi; ?></textarea>
                        </div>

                        <div class="form-group">
                          <label>Target</label>
                          <textarea class="form-control" name="target" rows="3"><?php echo $caleg->motivasi; ?></textarea>
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
                    <button class="btn btn-finish btn-danger" type="submit" name="submit" value="login" style="display: none;">Simpan</button>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </form>
            </div>
          </div>


<script src="<?php echo base_url('assets/js/core/jquery.3.2.1.min.js'); ?>"></script>
<script>

  $(document).ready(function(){

  $('#dapil').select2({
    theme: "bootstrap",
    width: '100%'
  });

  $("#tahun").datepicker({
    format: "yyyy",
    viewMode: "years", 
    minViewMode: "years"
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
