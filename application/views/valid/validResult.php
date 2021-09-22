    <div class="card col-12">
      <div class="card-header">
          <div class="card-title"><?php echo $pageTitle; ?></div>
      </div>
      <br>  
<br>

      <div class="well">
				<h2>Upload Set Analysis Result</h2>
				<table class="data table table-sm pmd-table">
					<thead>
						<tr>
							<th>#</th>
							<th>Komentar</th>
							<th>Stemmed Token</th>
							<th>Sentimen</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$n = 1;
					$tp = 0;
					$tn = 0;
					$fp = 0;
					$ff = 0;
					$salah = 0;
					foreach($valid->result() as $row){
						$stem = explode(",",$row->stem);
						if(count($stem) > 0){
							$stemmed = "<span class='badge badge-count'>".implode("</span> <span class='badge badge-count'>",$stem)."</span>";
				  }
						if($row->sentimen == 0){
							$out_sentimen = "<span class='btn btn-danger btn-sm'>Negatif</span>";
						}
						else if($row->sentimen == 1){
							$out_sentimen = "<span class='btn btn-success btn-sm'>Positif</span>";
						}
						else{
							$out_sentimen = "<span class='btn btn-warning btn-sm'>Netral</span>";
						}
						if($row->sentimen == $row->flag){
							$trclass = "";
						  } else {
							$trclass = "class='ikkehred'";
							$salah++;
						  }
						  if($row->sentimen == 1 && $row->sentimen == $row->flag){
							$tp++;
						}
						else if($row->sentimen == 1 && $row->sentimen !== $row->flag){
							$tn++;
						}
						else if($row->sentimen == 0 && $row->sentimen == $row->flag){
							$ff++;
						}
						else if($row->sentimen == 0 && $row->sentimen !== $row->flag){
							$fp++;
						}
						echo "
						<tr $trclass>
							<td>$n</td>
							<td>$row->komentar</td>
							<td>$stemmed</td>
							<td>$out_sentimen</td>
						</tr>
						";
						$n++;
					}
					?>
					</tbody>
				</table>

		</div>
		<table class="table table-bordered">
										<thead>
											<tr>
												<th scope="col">#</th>
												<th scope="col">Positif</th>
												<th scope="col">Negatif</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><b>Positif</b></td>
												<td><?php echo $tp ?></td>
												<td><?php echo $tn ?></td>
											</tr>
											<tr>
												<td><b>Negatif</b></td>
												<td><?php echo $fp ?></td>
												<td><?php echo $ff ?></td>
											</tr>
										</tbody>
									</table>
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