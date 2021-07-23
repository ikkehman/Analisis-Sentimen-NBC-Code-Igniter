<?php
error_reporting (E_ALL ^ E_NOTICE);
$analyze = new Analyze();
?>
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
<!-- end modal -->
    <div class="card col-12">
      <div class="card-header">
          <div class="card-title"><?php echo $pageTitle; ?></div>
      </div>
      <?php if($message = $this->session->flashdata('message')): ?>
            <div class="col s12">
              <div class="alert <?php echo ($message['status']) ? 'alert-success' : 'alert-danger'; ?>">
                <span class="white-text"><?php echo $message['message']; ?></span>
              </div>
            </div>
          <?php endif; ?>
        <div class="card-body"> 
            <a href="<?php echo base_url('multi/add'); ?>" class="btn btn-primary btn-border" style="float: right;">+ Batch Analysis</a>   
        </div>
      <form id="add-user-form" method="post" action="" enctype="multipart/form-data">
	  			<div class="form-group select2-input">
                  <label for="exampleFormControlSelect1">Data Pengujian</label>
                  <select required="required" id="dataset" name="dataset" onchange="loadDataset()" class="form-control">
                    <option value="" disabled selected>- Pilih Dataset -</option>
                    <?php foreach ($multi->result() as $m) {echo "<option value='$m->sets'>".format_indo(date($m->tgl))."</option>";}?>
                  </select>
                </div>
                <div class="row" style="padding-bottom: 20px;">
              <button type="submit" name="submit" value="login" class="btn btn-success">Lihat</button>&nbsp;
              <div id="renderArea"></div>
          </div>
        </form>
	
<script type="text/javascript">
    function loadDataset()
    {
        var dataset = $("#dataset").val();
        $.ajax({
            type:'GET',
            url:"<?php echo base_url(); ?>multi/pencetan",
            data:"dataset=" + dataset,
            success: function(html)
            { 
                $("#renderArea").html(html);
            }
        }); 
    }
</script>

<script type="text/javascript" language="JavaScript">
   $(document).ready(function(){
 
 $('#modal-konfirmasi').on('show.bs.modal', function (event) {
  var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
 
  // Untuk mengambil nilai dari data-id="" yang telah kita tempatkan pada link hapus
  var id = div.data('code')
 
  var modal = $(this)
 
  // Mengisi atribut href pada tombol ya yang kita berikan id hapus-true pada modal .
  modal.find('#hapus-true').attr("href","multi/delete/"+id);
 
 })
 
});
</script>