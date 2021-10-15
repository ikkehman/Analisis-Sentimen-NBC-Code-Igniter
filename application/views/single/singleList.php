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
<!--counter-->	
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