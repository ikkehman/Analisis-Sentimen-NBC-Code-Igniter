<style type="text/css">
.ikkeh a {
  color: black;
  text-decoration: none;
}

.geser
{
  padding-right: 10px;
}
</style>
  <!-- modal konfirmasi-->
<div id="modal-konfirmasi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content">
 
   <div class="modal-header">
    <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Konfirmasi</h4>
   </div>
 
   <div class="modal-body btn-info">
    Apakah Anda yakin ingin menghapus data ini?
   </div>
 
   <div class="modal-footer">
    <a href="javascript:;" class="btn btn-danger" id="hapus-true">Ya</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
   </div>
 
  </div>
 </div>
</div>

  <!-- modal input-->
<div id="modal-input" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content">
 
   <div class="modal-header">
    <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Disposisi</h4>
   </div>

           <form id="add-user-form" method="post" action="">
                <div class="form-group col-sm-6 select2-input">
              <label for="exampleFormControlSelect1">Kepada</label>
              <select required="required" id="pendaftar" name="tujuan" class="form-control">
                <option value="" disabled selected>- Pilih Penerima -</option>
                <?php foreach ($pengawas->result() as $p) {echo "<option value='$p->username'>$p->nama - $p->level</option>";}?>
              </select>
            </div> 
                <div class="form-group">
                  <label for="nama_norma">Keterangan</label>
                  <input type="text" class="form-control" required="" name="ket" id="jenis" value="">
                </div>

 
   <div class="modal-footer">
                  <button type="submit" name="submit" value="login" class="btn btn-success">Simpan</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
   </div>
 </form>
  </div>
 </div>
</div>



<div class="mail-wrapper">
            <div class="mail-content">
              <div class="email-head">
                <h3>
                  <i class="la la-star favorite"></i>
                  <?php echo ucwords($surat->perihal) ?>
                </h3>
                <div class="row controls">
                  <div class="card-title geser">
                    <a href="javascript:;" data-toggle="modal" data-target="#modal-input" class="btn btn-primary btn-border" style="float: right;"><i class="la la-mail-forward"></i> Disposisi</a>
                  </div>
                  <?php if($this->session->userdata('level') == 'administrator'): ?>
                  <div class="card-title">
                    <a href="javascript:;" data-toggle="modal" data-target="#modal-konfirmasi" class="btn btn-danger btn-border" data-id="<?php echo $surat->id_surat ?>" style="float: right;"><i class="la la-trash-o"></i> Delete</a>
                  </div>
                  <?php endif; ?>
                  
                </div>
              </div>
              <?php if($message = $this->session->flashdata('message')): ?>
            <div class="col s12">
              <div class="alert <?php echo ($message['status']) ? 'alert-success' : 'alert-danger'; ?>">
                <span class="white-text"><?php echo $message['message']; ?></span>
              </div>
            </div>
          <?php endif; ?>
              <div class="email-sender">
                <div class="avatar">
                  <img src="<?php echo base_url('assets/images/') . $surat->foto; ?>">
                </div>
                <div class="sender">
                  <a href="#" class="from"><?php echo ucwords($surat->pengirim) ?></a> kepada <a href="#" class="to"><?php echo ucwords($surat->penerima) ?></a> 
                  <div class="action ml-1">
                    <a data-toggle="dropdown" class="dropdown-toggle"></a>
                    <div role="menu" class="dropdown-menu">
                      <span class="dropdown-item">Dari: <?php echo ucwords($surat->pengirim." &lt;".$surat->level_s."&gt;") ?></span>
                      <span class="dropdown-item">Kepada: <?php echo ucwords($surat->penerima." &lt;".$surat->level_p."&gt;") ?></span>
                      <span class="dropdown-item">Waktu: <?php echo tgl_indo("Y-m-d",strtotime($surat->tanggal_dis)).', '.date("H:i",strtotime($surat->tanggal_dis)); ?></span>
                      <span class="dropdown-item">Status: <?php echo ucwords($surat->baca) ?></span>
                    </div>
                  </div>
                </div>
                <div class="date"><?php echo tgl_indo("Y-m-d",strtotime($surat->tanggal)).', '.date("H:i",strtotime($surat->tanggal)); ?></div>
              </div>
              <div class="email-sender">
                Perusahaan Pelanggar: <?php echo ($surat->nama_perusahaan) ?>
                <br>Norma yang Dilanggar: <?php echo ucwords($surat->nama_norma) ?>
                <br>Tanggal Pelanggaran : <?php echo tgl_indo($surat->tgl_pelang) ?>

              </div>
              <div class="email-body">
                <?php echo ($surat->isi) ?>
              </div>
              <?php if ($surat->lamp !== ''): ?>
              <div class="email-attachments">
                <div class="title">Attachments</div>
                <ul>
                  <li><a href="<?php echo base_url('assets/attachment/') . $surat->lamp; ?>"><i class="la la-paperclip"></i><?php echo ($surat->lamp) ?></a></li>
                </ul>
              </div>
            <?php endif; ?>
            </div>
          </div>

<script type="text/javascript" language="JavaScript">
   $(document).ready(function(){
 
 $('#modal-konfirmasi').on('show.bs.modal', function (event) {
  var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
 
  // Untuk mengambil nilai dari data-id="" yang telah kita tempatkan pada link hapus
  var id = div.data('id')
 
  var modal = $(this)
 
  // Mengisi atribut href pada tombol ya yang kita berikan id hapus-true pada modal .
  modal.find('#hapus-true').attr("href","surat/delete/"+id);
 
 });


 $('#modal-input').on('show.bs.modal', function (event) {
  var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
 
  // Untuk mengambil nilai dari data-id="" yang telah kita tempatkan pada link hapus
  var id = div.data('id')
 
  var modal = $(this)
 
  // Mengisi atribut href pada tombol ya yang kita berikan id hapus-true pada modal .
  modal.find('#save-true').attr("href","norma/tambah/");
 
 })
 
});
</script>