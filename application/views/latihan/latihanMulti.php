
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

		<?php var_dump ($test);?>
      <div class="well">
				<h2>Upload Set Analysis Result</h2>
				<table class="data table table-sm pmd-table">
					<thead>
						<tr>
							<th>#</th>
							<th>Komentar</th>
							<th>Stemmed Token</th>
							<th>Sentimen</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($latihan->result() as $k):?>
<?php   
        $no++;
        $salah = 0;
        $stem = explode(",",$k->stem);
			$stemmed = "";
			if(count($stem) > 0){
				$stemmed = "<span class='badge badge-count'>".implode("</span> <span class='badge badge-count'>",$stem)."</span>";
      }
      if($k->sentimen == 1){
				$senti = "<span class='btn-primary btn-sm btn-success'>Positif</span>";
			} else {
        $senti = "<span class='btn-primary btn-sm btn-danger'>Negatif</span>";
      }

      if($k->truesentimen === '1')
      $reviseto = 0;
    elseif($k->truesentimen === '0')
      $reviseto = 1;
    else{
      if($k->sentimen == -1){
        $reviseto = -1;
      }
      else{
        $reviseto = $k->sentimen == 1 ? 0 : 1;
      }
    }
    $trclass = "";
    $btn = "
    <a href='./salah?id=$k->no&revise=1' class='revise-btn btn btn-success btn-sm pmd-ripple-effect'>Positif</a>
  ";
  $btn2 = "
  <a href='./salah?id=$k->no&revise=0' class='revise-btn btn btn-danger btn-sm pmd-ripple-effect'>Negatif</a>
";

  if($k->sentimen == -1){
    $btn = "";
    $salah++;
    $trclass = "class='ikkehred'";
  }
    ?>
                    <tr <?php echo $trclass?>>
						<td><?php echo $no?></td>
						<td><?php echo $k->komentar?></td>
                        <td><?php echo $stemmed?></td>
						<td><?php echo $btn?></td>
						<td><?php echo $btn2?></td>
					</tr>
                <?php endforeach ?>
					</tbody>
				</table>
			</div>
      
      </div>
</div>

<script>
	$("body").on("click", ".revise-btn", function(e){
		e.preventDefault();
		target = $(this).attr("href");
		ctx = $(this);
		$.ajax({
			url : target,
			dataType : 'json'
		}).done(function(dt){
			ctx.closest("tr").attr("class","");
			ctx.closest("tr").addClass(dt['cls']);
			ctx.replaceWith(dt['btn']);
			count_tb();
		});
	});

	function count_tb(){
		var all = $('table tr').length - 1;
		var wrong = $('table tr.ikkehred').length;
		var valid = ((all - wrong) / all ) * 100;

		$('.all-span').text(all);
		$('.wrong-span').text(wrong);
		$('.percentage').text(valid+'%');
	}
</script>