<?php
error_reporting (E_ALL ^ E_NOTICE);
$analyze = new Analyze();
?>
    <div class="card col-12">
      <div class="card-header">
          <div class="card-title"><?php echo $pageTitle; ?></div>
      </div>
      <br>
      <form id="add-user-form" method="post" action="" enctype="multipart/form-data">
      <div class="form-group">
										<label for="defaultSelect">Default Select</label>
										<select name="persen" class="form-control form-control" id="defaultSelect">
											<option value="90">90%</option>
											<option value="80">80%</option>
											<option value="70">70%</option>
										</select>
                  </div>
                  <button type="submit" name="submit" value="ikkeh" class="btn btn-success">Process</button>
                  <button type="view" name="view" value="view" class="btn btn-info">View</button>
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