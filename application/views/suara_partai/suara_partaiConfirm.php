<div class="card col-10">
        <div class="card-header">
          <div class="card-title">Perhitungan Kursi
        </div></div>
        <div class="card-body">
          <?php 
$ikkeh=$this->db
         ->from('sainte')
         ->where('id_dapil',$code)
         ->get();
?>
        <form id="add-user-form" method="post" action="" enctype="multipart/form-data">
                  <?php if(validation_errors()): ?>
            <div class="col s12">
              <div class="card-panel red">
                <span class="white-text"><?php echo validation_errors('<p>', '</p>'); ?></span>
              </div>
            </div>
          <?php endif; ?>
          <?php if($message = $this->session->flashdata('message')): ?>
            <div class="col s12">
              <div class="alert <?php echo ($message['status']) ? 'alert-success' : 'alert-danger'; ?>">
                <span class="white-text"><?php echo $message['message']; ?></span>
              </div>
            </div>
          <?php endif; ?>
                    <div class="table-responsive">
                    <table id="tablePreview" class="table table-striped table-bordered">
                      <thead>
                    <tr>
                      <th class="center-align">No. Urut</th>
                      <th class="center-align">Nama Partai</th>
                      <th class="center-align">Total Suara</th>
                      <th class="center-align">Bagi 1</th>
                      <th class="center-align">Bagi 3</th>
                      <th class="center-align">Bagi 5</th>
                      <th class="center-align">bagi 7</th>
                      <th class="center-align">bagi 9</th>
                    </tr>
                      </thead>
                      <tbody>
                        <?php if($suarap): ?>
                  <?php $no = $this->uri->segment(3); foreach($suarap->result() as $row):?>
                  <?php $no = $this->uri->segment(3); foreach($suarac->result() as $rowc): ?>
                  <?php if($row->id_partai == $rowc->id_partai && $rowc->dapil == $row->w_dapil): ?>
                  <!--<?php //if($rowc->id_partai == $row->id_partai): ?>-->
                    <tr>
                      <td><?php echo $row->no_urutpartai; ?></td>
                      <td class="party">
                        <input type="hidden" name="parpol[]" value="<?php echo $row->id_partai; ?>"><?php echo $row->nama_partai; ?></td>
                      <td class="votes">
                        <input type="hidden" name="bpt1[]" value="<?php echo $row->totalp + $rowc->total; ?>"><?php echo ($row->totalp + $rowc->total); ?>
                      <td class="votes"><?php echo ($row->totalp + $rowc->total/ 1); ?>
                      <td class="votes">
                        <input type="hidden" name="bpt3[]" value="<?php echo  round( ($row->totalp + $rowc->total) / 3); ?>"><?php echo  round( ($row->totalp + $rowc->total) / 3); ?>
                      </td>
                      <td class="votes">
                        <input type="hidden" name="bpt5[]" value="<?php echo round(($row->totalp + $rowc->total) / 5); ?>"><?php echo  round(($row->totalp + $rowc->total) / 5); ?>
                      <td class="votes">
                        <input type="hidden" name="bpt7[]" value="<?php echo round(($row->totalp + $rowc->total) / 7); ?>"><?php echo  round(($row->totalp + $rowc->total) / 7); ?>
                      <td class="votes">
                        <input type="hidden" name="bpt9[]" value="<?php echo round(($row->totalp + $rowc->total) / 9); ?>"><?php echo  round(($row->totalp + $rowc->total) / 9); ?>
                    </tr>
                    <!--<?php// endif; ?>-->
                    <?php endif; ?>
                    <?php endforeach; ?>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td class="center-align" colspan="6">Belum ada data kejuruan</td>
                  </tr>
                <?php endif; ?>
                      </tbody>
                    </table>

        <div class="row" style="padding-bottom: 20px; float: right;">
              <?php if ($ikkeh->num_rows() == 0): ?>
                <button type="submit" name="submit" value="login" class="btn btn-success">Simpan</button>
                <?php else: ?>
                 <a href="<?php echo base_url('suara_partai/result/'.$code); ?>" class="btn btn-primary btn-border" style="float: right;">Lihat Hasil Perhitungan</a>
               <?php endif; ?>
          </div>

                    <div class="card-body">
          </div>
                  </div></div>
                </div>

<script type="text/javascript" language="JavaScript">
 function konfirmasi()
 {
 tanya = confirm("Anda Yakin Akan Menghapus Data ?");
 if (tanya == true) return true;
 else return false;
 }</script>

<!--  dddddd -->