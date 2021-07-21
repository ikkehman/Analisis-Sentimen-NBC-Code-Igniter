<?php
error_reporting (E_ALL ^ E_NOTICE);
$analyze = new Analyze();
?>
    <div class="card col-12">
      <div class="card-header">
          <div class="card-title"><?php echo $pageTitle; ?></div>
      </div>
      <br>
      <form action="" method="get" action="" enctype="multipart/form-data">
      <div class="form-group">
										<label for="defaultSelect">Default Select</label>
										<select name="persen" class="form-control form-control" id="defaultSelect">
											<option value="90">90%</option>
											<option value="80">80%</option>
											<option value="70">70%</option>
										</select>
                  </div>
                  <button type="submit" name="submit" value="ikkeh" class="btn btn-success">Process</button>
</form>   
<?php var_dump ($test); ?>
<br>
<?php if(isset($_GET['persen'])) ?>
<?php if($r > 0): ?>
<?php if($r > 0): ?>
		<?php var_dump ($out_text);?>
      <div class="well">
				<h2>Upload Set Analysis Result</h2>
				<table class="data table table-sm pmd-table">
					<thead>
						<tr>
							<th>#</th>
							<th>ID Set</th>
							<th>Komentar</th>
							<th>Stemmed Token</th>
							<th>Sentimen</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$n = 1;
					for($i=0; $i<$r;$i++){	
						$stemmed = "";
						if(count($stem[$i]) > 0){
							$stemmed = "<span class='label label-primary'>".implode("</span> <span class='label label-primary'>",$stem[$i])."</span>";
						}

						if($lang[$i] == 0){
							$out_sentimen = "<span class='btn btn-danger btn-sm'>Negatif</span>";
						}
						else if($lang[$i] == 1){
							$out_sentimen = "<span class='btn btn-success btn-sm'>Positif</span>";
						}
						else{
							$out_sentimen = "<span class='btn btn-warning btn-sm'>Netral</span>";
						}

						echo "
						<tr>
							<td>$n</td>
							<td>$sets</td>
							<td>$out_text[$i]</td>
							<td>$stemmed</td>
              <td>$out_sentimen</td>
						</tr>
						";
						$n++;
					}
					?>
					</tbody>
				</table>
        <?php endif; ?>
        <?php endif; ?>
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