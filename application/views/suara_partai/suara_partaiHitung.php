  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
       //load package
       google.load('visualization', '1', {packages: ['corechart']});
 </script>


    <div class="card col-10">
    <div class="card-header">
      <div class="card-title"><?php echo $pageTitle; ?></div>
    </div>

    <nav style="padding-top: 15px">
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Hitung Kursi</a>
    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Perolehan Suara</a>
    <!--<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Chart</a>-->
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
    <!--start-->
                <div class="card-header">
                  <div class="card-head-row">
                    <h6>Dapil <?php echo $dapil; ?></h6>
                  </div>
                </div>

<?php if($winner): ?>
<?php $no = $this->uri->segment(3); foreach($winner->result() as $w): ?>
<?php if($suarap): ?>
<?php $no = $this->uri->segment(3); foreach($suarap->result() as $row): ?>
<?php if($w->parpol == $row->id_partai && $w->id_dapil == $dapil): ?>
  <table class="table table-bordered" >
  <tr style="background: #f9f8f8;">
    <th>No. Urut</th>
    <th>Lambang</th>
    <th>Nama Partai</th>
    <th>Suara Partai</th>
  </tr>
  <tr>
    <td><?php echo $row->no_urutpartai; ?></td>
    <td><img style="max-width : 50px" src="<?php echo base_url('assets/images/') ?><?php echo $row->lambang; ?>" alt="indonesia"></td>
    <td><?php echo $row->nama_partai; ?></td>
    <td><?php echo number_format($row->totalp,0,',','.'); ?></td>
  </tr>

<!--caleg-->
<?php 

                  $query = $this->db->select('*,`caleg`.`id_partai` as party')
                  ->select_sum('jsuara_caleg','total')
                  ->from('suara_caleg')
                  ->join('caleg', 'caleg.id_caleg = suara_caleg.id_calegx')
                  ->join('partai', 'partai.id_partai = caleg.id_partai')
                  ->join('regencies', 'regencies.id_regen = suara_caleg.id_regenc')
                  ->where(array('w_dapil' => $dapil))
                  ->where(array('tahun_caleg' => '2019'))
                  ->where(array('caleg.id_partai' => $row->id_partai))
                  ->group_by('id_calegx')
                  ->order_by('total', 'desc')
                  ->get();
?>
<tr style="background: #f9f8f8;">
    <th></th>
    <th>Nomor Urut</th>
    <th>Nama</th>
    <th>Suara Caleg</th>
  </tr>
<?php if($query): ?>
<?php $no = $this->uri->segment(3); foreach(array_slice($query->result(), 0, $w->hitung) as $row2): ?>

  <tr>
    <td></td>
    <td><?php echo $row2->no_urutcal; ?></td>
    <td><?php echo $row2->nama; ?></td>
    <td><?php echo number_format($row2->total,0,',','.'); ?></td>
  </tr>

<?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td class="center-align" colspan="6">Belum ada data caleg</td>
    </tr>
  <?php endif; ?>
<!--caleg end-->

<!--total-->
  <tr style="background: #f9f8f8;">
    <td colspan="5"></td>
  </tr>
<!--total end-->
   </table>
  <?php endif; ?>
  <?php endforeach; ?>
  <?php endif; ?>
  <?php endforeach; ?>
  <?php endif; ?>

<!--finish-->
  </div>
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
    
                <div class="card-header">
                  <div class="card-head-row">
                    <h6>Dapil <?php echo $dapil; ?></h6>
                  </div>
                </div>

<?php if($suarap): ?>
<?php $no = $this->uri->segment(3); foreach($suarap->result() as $row): ?>
  <table class="table table-bordered" >
  <tr style="background: #f9f8f8;">
    <th>No. Urut</th>
    <th>Lambang</th>
    <th>Nama Partai</th>
    <th>Suara Partai</th>
  </tr>
  <tr>
    <td><?php echo $row->no_urutpartai; ?></td>
    <td><img style="max-width : 50px" src="<?php echo base_url('assets/images/') ?><?php echo $row->lambang; ?>" alt="indonesia"></td>
    <td><?php echo $row->nama_partai; ?></td>
    <td><?php echo number_format($row->totalp,0,',','.'); ?></td>
  </tr>

<!--caleg-->
<?php 

                  $query = $this->db->select('*,`caleg`.`id_partai` as party')
                  ->select_sum('jsuara_caleg','total')
                  ->from('suara_caleg')
                  ->join('caleg', 'caleg.id_caleg = suara_caleg.id_calegx')
                  ->join('partai', 'partai.id_partai = caleg.id_partai')
                  ->join('regencies', 'regencies.id_regen = suara_caleg.id_regenc')
                  ->where(array('w_dapil' => $dapil))
                  ->where(array('tahun_caleg' => '2019'))
                  ->where(array('caleg.id_partai' => $row->id_partai))
                  ->group_by('id_calegx')
                  ->order_by('no_urutcal', 'asc')
                  ->get();

                  $query2 = $this->db->select('*,`caleg`.`id_partai` as party')
                  ->select_sum('jsuara_caleg','total')
                  ->from('suara_caleg')
                  ->join('caleg', 'caleg.id_caleg = suara_caleg.id_calegx')
                  ->join('partai', 'partai.id_partai = caleg.id_partai')
                  ->join('regencies', 'regencies.id_regen = suara_caleg.id_regenc')
                  ->where(array('w_dapil' => $dapil))
                  ->where(array('tahun_caleg' => '2019'))
                  ->where(array('caleg.id_partai' => $row->id_partai))
                  ->group_by('party')
                  ->order_by('no_urutcal', 'asc')
                  ->get();
?>
<tr style="background: #f9f8f8;">
    <th></th>
    <th>Nomor Urut</th>
    <th>Nama</th>
    <th>Suara Caleg</th>
  </tr>
<?php if($query): ?>
<?php $no = $this->uri->segment(3); foreach($query->result() as $row2): ?>

  <tr>
    <td></td>
    <td><?php echo $row2->no_urutcal; ?></td>
    <td><?php echo $row2->nama; ?></td>
    <td><?php echo number_format($row2->total,0,',','.'); ?></td>
  </tr>

<?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td class="center-align" colspan="6">Belum ada data caleg</td>
    </tr>
  <?php endif; ?>
<!--caleg end-->

<!--total-->
<?php if($query2): ?>
<?php $no = $this->uri->segment(3); foreach($query2->result() as $rowx): ?>
  <tr style="background: #f9f8f8;">
    <td colspan="3">Total</td>
    <td><?php echo number_format($row->totalp + $rowx->total,0,',','.'); ?></td>
<?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td class="center-align" colspan="6">Belum ada data</td>
    </tr>
  <?php endif; ?>
  </tr>
<!--total end-->
   </table>
  <?php endforeach; ?>
  <?php endif; ?>

<!--finish-->

  </div>
  <!--<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
     <div id="visualization"></div>
  </div> -->
</div>

</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

var doughnutChart = document.getElementById('spieChart').getContext('2d');

var myDoughnutChart = new Chart(doughnutChart, {
  type: 'pie',
  data: {
    datasets: [{
      data: [      
<?php if($suarap): ?>
<?php $no = $this->uri->segment(3); foreach($suarap->result() as $rowx): ?>
    <?php echo $rowx->totalp.','; ?>
<?php endforeach; ?>
  <?php else: ?>
  <?php endif; ?>
      ],
      backgroundColor: ["#dc3545","#fd7e14","#ffc107","#28a745","#007bff","#e83e8c","#6f42c1","#e83e8c","#6c757d","#3fe0e6","#2920c9","#c354f3"]
    }],

    labels: [
    'Partai 1', 'Partai 2', 'Partai 3', 'Partai 4', 'Partai 5', 'Partai 6', 'Partai 7', 'Partai 8', 'Partai 9', 'Partai 10', 'Partai 11', 'Partai 12'
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    legend : {
      position: 'bottom'
    },
    legend: {
      position : 'bottom',
      labels : {
        fontColor: 'rgb(154, 154, 154)',
        fontSize: 11,
        usePointStyle : true,
        padding: 20
      }
    },
    pieceLabel: {
      render: 'percentage',
      fontColor: 'white',
      fontSize: 14,
    },
    layout: {
      padding: {
        left: 20,
        right: 20,
        top: 20,
        bottom: 20
      }
    }
  }
});

    });
</script>
<?php $result = $pie_data;
    //get number of rows returned
    $num_results = $result->num_rows;
    $ikkeh = $row->totalp;
    ?>
        <script type="text/javascript">
            function drawVisualization() {
                // Create and populate the data table.
                var data = google.visualization.arrayToDataTable([
                    ['PL', 'Ratings'],
                    <?php
                    foreach ($result->result_array() as $row) {
                        extract($row);
                        echo "['{$nama_partai}', {$ikkeh}],";
                    } ?>
                ]);
                // Create and draw the visualization.
                new google.visualization.PieChart(document.getElementById('visualization')).
                draw(data, {title:"Data Penjualan Kendaraan Bermotor Tahun 2015"});
            }
 
            google.setOnLoadCallback(drawVisualization);
        </script>
