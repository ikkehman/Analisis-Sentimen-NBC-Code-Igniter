<div class="content">
<div class="container-fluid">
<div class="page-header">
	<h4 class="page-title">Dashboard</h4>
</div>

<div class="row">
						<div class="col-sm-6 col-md-4">
							<div class="card card-stats card-primary card-round">
								<div class="card-body ">
									<div class="row">
										<div class="col-5">
											<div class="icon-big text-center">
												<i class="flaticon-success"></i>
											</div>
										</div>
										<div class="col-7 col-stats">
											<div class="numbers">
												<p class="card-category">Total Data Latih</p>
												<h4 class="card-title"><?php echo $hitungtot;?></h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="card card-stats card-success card-round">
								<div class="card-body">
									<div class="row">
										<div class="col-5">
											<div class="icon-big text-center">
												<i class="flaticon-hands"></i>
											</div>
										</div>
										<div class="col-7 col-stats">
											<div class="numbers">
												<p class="card-category">Data Latih Positif</p>
												<h4 class="card-title"><?php echo $hitungpos;?></h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-4">
							<div class="card card-stats card-danger card-round">
								<div class="card-body ">
									<div class="row">
										<div class="col-5">
											<div class="icon-big text-center">
												<i class="flaticon-hands-1"></i>
											</div>
										</div>
										<div class="col-7 col-stats">
											<div class="numbers">
												<p class="card-category">Data Latih Negatif</p>
												<h4 class="card-title"><?php echo $hitungneg;?></h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
							<div class="card">
								<div class="card-header">
									<div class="card-head-row">
										<div class="card-title">Statistics</div>
										<div class="card-tools">
											<a href="#" class="btn btn-info btn-border btn-round btn-sm mr-2">
												<span class="btn-label">
													<i class="la la-pencil"></i>
												</span>
												Export
											</a>
											<a href="#" class="btn btn-info btn-border btn-round btn-sm">
												<span class="btn-label">
													<i class="la la-print"></i>
												</span>
												Print
											</a>
										</div>
									</div>
								</div>
								<div class="card-body">
								<canvas id="myChart"></canvas>
								</div>
							</div>
						</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"></script>
<script type="text/javascript">
    const chartSiswa = document.getElementById('myChart').getContext('2d');
    const chart = new Chart(chartSiswa, {
        type: 'doughnut',
        data: {
            labels: ['Total Data','Data Positif','Data Negatif'], // data tahun sebagai label dari chart
            datasets: [{
                label: 'Jumlah Peserta',
                backgroundColor: ['#177dffdb', '#35cd3ae8', '#fb333e'],
                data: [<?php echo $hitungtot;?>,<?php echo $hitungpos;?>,<?php echo $hitungneg;?>] //data siswa sebagai data dari chart
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
</div>