
<div class="card col-12">
    <div class="card-header">
                      <div class="card-title"><?php echo $pageTitle; ?></div>
                    </div>
      <div class="card-content">
      <div class="card-body">

        <div class="alert btn-secondary">
			      Masukkan data set kalimat uji yang ingin dianalisa dalam format Excel untuk diolah secara langsung.
            <br>
			      <a href="assets/contoh.xlsx" class="btn btn-primary" target="_blank"><span class="btn-label"><i class="la la-download"></i></span>Download Contoh Format File</a>
		        </div>
	      <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group files color justify-content-center">
                <input type="file" name="file_batch" class="form-control" accept=".xls, .xlsx, .csv">
              </div>
              <div class="d-flex justify-content-center">
              <button name="btn" class="btn btn-primary pmd-ripple-effect">Process</button>
              </div>
        </form>

      </div>

	  <?php if($r > 0): ?>
		<?php var_dump ($test);?>
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
			</div>
      
      </div>
</div>