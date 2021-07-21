    <div class="card col-10">
    <div class="card-header">
                      <div class="card-title"><?php echo $pageTitle; ?></div>
                    </div>
      <div class="card-content">
<?php 
$ikkeh=$this->db
         ->from('suara_partai')
         ->where('id_regenc',$this->session->userdata('wilayah'))
         ->get();
?>
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
        <?php if($wilayah): ?>
                  <?php $no = $this->uri->segment(3); foreach($wilayah->result() as $row): ?>

<?php 
$ikkeh=$this->db
         ->from('suara_partai')
         ->where('id_regenc',$row->id_regen)
         ->get();
?>
                    <?php if ($ikkeh->num_rows() == 0):?>
                    <div class="row row-card-no-pd">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="card-head-row">
                    <h6><?php echo $row->name; ?></h6>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive table-sales">
                        <table class="table">
                          <tbody>
                            <?php if($partai): ?>
                  <?php $no = $this->uri->segment(3); foreach($partai->result() as $p): ?>
                            <tr style="background-color: #f0f0f0;">
                              <td><b><?php echo $p->no_urutpartai; ?></b></td>
                              <td>
                                <div class="flag">
                                  <img style="max-width : 50px" src="<?php echo base_url('assets/images/') ?><?php echo $p->lambang; ?>" alt="indonesia">
                                </div>
                              </td>
                              <td><b><?php echo $p->nama_partai; ?></b></td>
                              <td class="text-right">
                                <input type="hidden" name="id_regenc1[]" value="<?php echo $row->id_regen; ?>">
                                <input type="hidden" name="id_partai[]" value="<?php echo $p->id_partai; ?>">
                                <input type="text" maxlength="12" class="form-control input-default" id="telp" name="jsuara_partai[]" onkeypress="return isNumber(event)" value="" required="required" placeholder="Masukan Suara" />
                              </td>
                            </tr>
                            <?php if($caleg): ?>
                  <?php $no = $this->uri->segment(3); foreach($caleg->result() as $c): ?>
                  <?php if($c->id_partai == $p->id_partai && $c->dapil == $row->w_dapil): ?>

                            <tr>
                              <td></td>
                              <td><?php echo $c->no_urutcal; ?></td>
                              <td><?php echo $c->nama; ?></td>
                              <td class="text-right">
                                <input type="hidden" name="id_calegx[]" value="<?php echo $c->id_caleg; ?>">
                                <input type="hidden" name="id_regenc[]" value="<?php echo $row->id_regen; ?>">
                                <input type="text" maxlength="12" class="form-control input-default" id="telp" name="jsuara_caleg[]" onkeypress="return isNumber(event)" value="" required="required" placeholder="Masukan Suara" />
                              </td>
                            </tr>

                            <?php endif; ?>
                            <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td class="center-align" colspan="6">Belum ada data Caleg</td>
                  </tr>
                <?php endif; ?>
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>

                            <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td class="center-align" colspan="6">Belum ada data Partai</td>
                  </tr>
                <?php endif; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
                <?php else: ?>
                  <div class="row row-card-no-pd">
            <div class="col-md-12">
              <div class="card">
<b>Data <?php echo $row->name; ?> sudah terisi
              </div>
            </div>
          </div>
                <?php endif; ?>
                  <?php endforeach; ?>
                <?php else: ?>
                <?php endif; ?>
        <div class="row" style="padding-bottom: 20px; float: right;">
              <?php if ($ikkeh->num_rows() == 0): ?>
                <button type="submit" name="submit" value="login" class="btn btn-success">Simpan</button>
                <?php elseif($ikkeh->num_rows() > 1 && $this->session->userdata('level') == 'administrator'): ?>
                 <a href="<?php echo base_url('suara_partai/confirm/'.$code); ?>" class="btn btn-primary btn-border" style="float: right;">Konfirmasi Suara</a>
                 <?php elseif($ikkeh->num_rows() > 1 && $this->session->userdata('level') !== 'administrator'): ?>
                 <a href="<?php echo base_url('suara_partai/result/'.$code); ?>" class="btn btn-primary btn-border" style="float: right;">Lihat Hasil Perhitungan</a>
               <?php endif; ?>
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

