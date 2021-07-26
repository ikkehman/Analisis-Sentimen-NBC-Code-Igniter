<div class="card col-12">
    <div class="card-header">
                      <div class="card-title"><?php echo $pageTitle; ?></div>
                    </div>
      <div class="card-content">
      <div class="card-body">
									<table class="table table-hover">
                  <thead>
            <tr>
              <th scope='col'>#</th>
              <th scope='col'>Tanggal</th>
              <th scope='col'>Komentar</th>
              <th scope='col'>Stem</th>
              <th scope='col'>Sentimen</th>
              <th scope='col'>True Sentimen</th>
            </tr>
          </thead>
										<tbody>
                <?php foreach ($lengkap->result() as $k):?>
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
    <a href='../salah?id=$k->id&revise=$reviseto' class='revise-btn btn btn-info btn-sm pmd-ripple-effect'>Tandai sbg kesalahan</a>
  ";
  if(is_numeric($k->truesentimen)){
    if($k->sentimen <> $k->truesentimen){
      $trclass = "class='ikkehred'";
      $btn = "
      <a href='../salah?id=$k->id&revise=$reviseto' class='revise-btn btn btn-warning btn-sm pmd-ripple-effect'>Hapus Tanda Kesalahan</a>
      ";
      $salah++;
    }
  }
  if($k->sentimen == -1){
    $btn = "";
    $salah++;
    $trclass = "class='ikkehred'";
  }
    ?>
                      <tr <?php echo $trclass?>>
												<td><?php echo $no?></td>
												<td><?php echo $k->tgl?></td>
												<td><?php echo $k->komentar?></td>
                        <td><?php echo $stemmed?></td>
                        <td><?php echo $senti?></td>
                        <td><?php echo $btn?></td>
											</tr>
                <?php endforeach ?>
										</tbody>
									</table>
								</div>
      </div>
    </div>


<script src="<?php echo base_url('assets/js/core/jquery.3.2.1.min.js'); ?>"></script>

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
<div class="row">
	<div class="col-sm-3">
		<strong>Jumlah Data Uji</strong>
	</div>
	<div class="col-sm-3"> : <span class="all-span"><?php foreach ($total_data->result() as $row){$fixtot=$row->total;} echo $fixtot ?></span></div>
</div>
<div class="row">
	<div class="col-sm-3">
		<strong>Jumlah Kesalahan</strong>
	</div>
	<div class="col-sm-3"> : <span class="wrong-span"><?php foreach ($total_salah->result() as $row){$fixsal=$row->total_salah;} echo $fixsal ?></span></div>
</div>
<div class="row">
	<div class="col-sm-3">
		<strong>Persentase Validasi</strong>
	</div>
	<div class="col-sm-3"> : <mark><span class="percentage"><?php
		$skor = (($fixtot - $fixsal) / $fixtot) * 100;
		$skor = number_format($skor,2,",",".");
		echo $skor;
	?>%</span></mark></div>
</div>