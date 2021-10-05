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
	<div class="input-group">
		<input type="text" class="form-control" name="kalimat">
		<div class="input-group-btn">
			<button class="btn btn-primary">Proses</button>
		</div>
	</div>
</form>
<hr>
<?php if(isset($_GET['kalimat'])): ?>

  <div class="card-body">
        <?php $sentimen = $analyze->single_process($_GET['kalimat']);
              echo " <strong><h6>Kalimat Input : </strong></h6>";
	            echo "$_GET[kalimat]"; ?>
  </div>

  <div class="card-body">
        <strong><h6>Stemmed Input : </h6></strong> 
	      <?php foreach($analyze->input as $stem){
		          echo "<span class='btn btn-primary btn-border btn-round btn-sm'>$stem</span> ";
              } 
        ?> 
  </div>

	<?php $jml = count($analyze->use['komentar']) - 1; ?>

  <div class="card-body">
	        <strong><h6>Jumlah data latih ditemukan : <?php echo ($jml) ?> </h6></strong>
	        <ol>
              <?php
	              for($i=1; $i<count($analyze->use['komentar']); $i++){
		            if ($analyze->use['sentimen'][$i] == '1')
			              $ikkeh = " <span class='badge badge-success'><b>Positif</b></span>";
                else 
                    $ikkeh = " <span class='badge badge-danger'><b>Negatif</b></span>";
		            echo "<li>". $analyze->use['komentar'][$i].$ikkeh."</li>";
                }
              ?>
	        </ol>
  </div>

  <div class="card-body">
	    <strong><h6>Stemmed Data Latih : </h6></strong><p>
	    <ol>
          <?php
	          for($i=1; $i<count($analyze->use['stem']); $i++){
		        echo "<li>";
		        if ($analyze->use['sentimen'][$i] == '1')
			          $ikkeh = " <span class='btn-primary btn-sm btn-success'><b>";
            else 
                $ikkeh = " <span class='btn-primary btn-sm btn-danger'><b>";

		        foreach($analyze->use['stem'][$i] as $itm){
			          echo "$ikkeh$itm</b></span> ";
		          }
		            echo "</li> <p>";
            }
          ?>
	    </ol>
  </div>
  
<?php  
/*
echo "<br>";
	echo "<strong>Word Token : </strong>";
	echo "<ol>";
	foreach($analyze->tokend as $tknd){
		foreach($analyze->token as $tkn){
		if ($tknd == $tkn) 
			echo "<li><span class='label label-primary'>$tknd</span></li>";
	}
	}
	echo "</ol>";
	echo "<br>";
///
		echo "<br>";

	echo "<br>";
	echo "<strong>TF (Term Frequency) & DF (Document Frequency)</strong>";
	echo "<table class='table table-sm pmd-table'>";
	echo "<tr>";
	echo "<th></th>";
	echo "<th>IDF</th>";
	for($i=1; $i<=$jml; $i++){
		echo "<th><span class='label label-primary'>TF-".$i."</span></th>";
	}
	echo "<th>DF</th>";
	echo "<tr>";
	foreach($analyze->tf as $kata=>$ar){
		$ddf[$kata] = number_format(log10(($analyze->df[$kata] == 0) ? 1 : ($jml / $analyze->df[$kata])),3,",",".");

		echo "<tr>";
		echo "<th>$kata</th>";
		echo "<td>$ddf[$kata]</td>";
		for($i=1; $i<=$jml; $i++){
			echo "<td>$ar[$i]</td>";
		}
		echo "<td>".$analyze->df[$kata]."s"."</td>";
		echo "</tr>";
	}
	echo "</table>";
	echo "<br>";


	echo "<strong>Bobot TF * IDF</strong>";
	echo "<table class='table table-sm pmd-table'>";
	echo "<tr>";
	echo "<th></th>";
	for($i=1; $i<=$jml; $i++){
		echo "<th><span class='label label-primary'>W-".$i."</span></th>";
	}
	echo "<tr>";
	foreach($analyze->tf as $kata=>$ar){
		$ddf[$kata] = log10(($analyze->df[$kata] == 0) ? 1 : ($jml / $analyze->df[$kata]));

		echo "<tr>";
		echo "<th>$kata</th>";
		for($i=1; $i<=$jml; $i++){
			$bobot = $ar[$i] * $ddf[$kata];
			echo "<td>".number_format($bobot,3,".",",")."</td>";

			if(!isset($w[$i]))
				$w[$i] = $bobot;
			else{
				$w[$i] += $bobot;
			}
		}
		echo "</tr>";
	}
	echo "<tr>";
	echo "<td></td>";
	foreach($w as $bbt){
		echo "<td><strong>$bbt</strong></td>";
	}

	echo "</tr>";

	echo "</table>";
*/
	///
	?>

<!--counter-->	
<?php 
/*
$s= array_keys($analyze->use['sentimen'], "1");
$yzf =count(array_keys($analyze->use['sentimen'], "1"));
foreach ($s as $katap) {
    $hitp[$katap] = $analyze->use['stem'][$katap];
	}
$npos = (count($hitp, COUNT_RECURSIVE)-$yzf);

$sn= array_keys($analyze->use['sentimen'], "0");
$yz =count(array_keys($analyze->use['sentimen'], "0"));
foreach ($sn as $katan) {
    $hitn[$katan] = $analyze->use['stem'][$katan];
	}
$nneg = (count($hitn, COUNT_RECURSIVE)-$yz);
$tbig = $npos + $nneg;
*/
?>
<!--end counter-->	

<!--positif -->
<?php 
/*
$sumArray = array();
foreach ($s as $kata) {
foreach ($analyze->bobot as $k=>$subArray) {
  foreach ($subArray as $id=>$value) {
  	if ($id == $kata) {
  		$sumArray[$k]+=$value;
  	}
    
  }
}
}

foreach($analyze->tokend as $kata){
	$tot[$kata] = ($sumArray[$kata] + 1) / ($npos+$tbig);
}

$temp = 1;
foreach($tot as $key => $value) {
$temp *= $value;
}
$nbc = $temp*0.5;
*/
?>
<!--end positif-->

<!--negatif-->
<?php /*
$sumArrayn = array();
foreach ($sn as $katan) {
foreach ($analyze->bobot as $k=>$subArray) {
  foreach ($subArray as $id=>$value) {
  	if ($id == $katan) {
  		$sumArrayn[$k]+=$value;
  	}
    
  }
}
}

foreach($analyze->tokend as $kata){
	$totn[$kata] = ($sumArrayn[$kata] + 1) / ($nneg+$tbig);
}

$tempn = 1;
foreach($totn as $key => $value) {
$tempn *= $value;
}
$nbcn = $tempn*0.5; */
?>
<!--end negatif-->
<?php
if ($analyze->nbc>$analyze->nbcn) {
	$stt = "<span class='text-success'><b>Positif</b></span> ";
} else {
	$stt = "<span class='text-danger'><b>Negatif</b></span> ";
}
?>
<div class="card-body">
	<strong><h6>Hasil Final : </h6></strong>
	<ul>
			<li><b>Positif :</b> <?php echo ($analyze->nbc) ?></li>
			<li><b>Negatif :</b> <?php echo ($analyze->nbcn) ?></li>				
	</ul>
</div>
<hr>
	<div class='well'><h3><strong>Final Sentiment : </strong><?php echo ($stt) ?></h3></div>
<hr>

	</ul> </div>
  <?php endif; ?>