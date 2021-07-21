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

<div class="mail-wrapper">
            <div class="mail-content">
              <div class="email-head">
                <h3>
                  <i class="la la-star favorite"></i>
                  <?php echo ucwords($berita->subjek) ?>
                </h3>
                <div class="row controls">
                  <?php if($this->session->userdata('level') == 'pengawas'): ?>
                  <div class="card-title">
                    <a href="javascript:;" data-toggle="modal" data-target="#modal-konfirmasi" class="btn btn-danger btn-border" data-id="<?php echo $berita->id_berita ?>" style="float: right;"><i class="la la-trash-o"></i> Delete</a>
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
                  <img src="<?php echo base_url('assets/images/') . $berita->avatar; ?>">
                </div>
                <div class="sender">
                  <a href="#" class="from"><?php echo ucwords($berita->pengirim) ?></a>
                  <div class="action ml-1">
                    <a data-toggle="dropdown" class="dropdown-toggle"></a>
                    <div role="menu" class="dropdown-menu">
                      <span class="dropdown-item">Dari: <?php echo ucwords($berita->pengirim." &lt;".$berita->level."&gt;") ?></span>
                      <span class="dropdown-item">Waktu: <?php echo tgl_indo("Y-m-d",strtotime($berita->tgl_berita)).', '.date("H:i",strtotime($berita->tgl_berita)); ?></span>
                    </div>
                  </div>
                </div>
                <div class="date"><?php echo tgl_indo("Y-m-d",strtotime($berita->tgl_berita)).', '.date("H:i",strtotime($berita->tgl_berita)); ?></div>
              </div>
              <div class="email-sender">
                Perusahaan Pelanggar: <?php echo ($berita->nama_perusahaan) ?>
                <br>Norma yang Dilanggar: <?php echo ucwords($berita->nama_norma) ?>
                <br>Tanggal Pelanggaran : <?php echo tgl_indo($berita->tgl_pelang) ?>

              </div>
              <div class="email-body">
                <?php echo ($berita->desk) ?>
              </div>
              <?php if ($berita->lampiran !== ''): ?>
              <div class="email-attachments">
                <div class="title">Attachments</div>
                <ul>
                  <li><a href="<?php echo base_url('assets/attachment/') . $berita->lampiran; ?>"><i class="la la-paperclip"></i><?php echo ($berita->lampiran) ?></a></li>
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
  modal.find('#hapus-true').attr("href","berita/delete/"+id);
 
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