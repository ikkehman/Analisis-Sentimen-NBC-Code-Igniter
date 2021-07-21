<style type="text/css">
  .ikkeh a {
    color: black;
    text-decoration: none;
}
  }
</style>
<div class="mail-wrapper">
            <div class="mail-content">
              <div class="inbox-head">
                <h3><?php echo $pageTitle; ?></h3>
                <form action="<?php echo base_url('surat/cari'); ?>" class="ml-auto" method="post">
                  <div class="input-group">
                    <input type="text" name="key" placeholder="Cari Surat..." class="form-control">
                    <div class="input-group-append">
                      <button type="submit" class="btn input-group-text">
                        <i class="la la-search search-icon"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="inbox-body">
                <div class="mail-option">
                  <div class="email-filters-left">
                                        <div class="card-title"><a href="<?php echo base_url('surat/add'); ?>" class="btn btn-primary btn-border" style="float: right;">+ Tambah Surat</a>
                  </div>
                  </div>
                </div>

                <div class="email-list">
                  <?php if($surat): ?>
                  <?php $no = $this->uri->segment(3); foreach($surat as $row): ?>

                  <?php if($row['baca'] == 'unread'): ?>
                  <div class="email-list-item unread">
                  <?php else: ?>
                  <div class="email-list-item read">
                  <?php endif; ?>
                    <div class="email-list-actions">
                      <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input"><span class="custom-control-label"></span>
                      </label><a href="<?php echo base_url('surat/lihat/' . $row['id_surat']); ?>" class="favorite active"></a>
                    </div>
                    <div class="email-list-detail ikkeh">
                      <a href="<?php echo base_url('surat/lihat/' . $row['id_surat']); ?>">

                      <div class="col-sm-4 float-right">
                      <span class="date float-right">
                        <?php if($row['lamp'] !== ''): ?>
                        <i class="la la-paperclip paperclip"></i>
                        <?php endif; ?>
                        <?php echo tgl_indo("Y-m-d",strtotime($row['tanggal'])).', '.date("H:i",strtotime($row['tanggal'])); ?></span>
                        </div>


                        <span class="from"><?php echo $row['pengirim']; ?> > <?php echo $row['penerima']; ?></span>
                      <p class="msg"><?php echo $row['perihal']; ?></p>
                    </a>
                    </div>
                  </div>
                  <?php endforeach; ?>

                  <?php else: ?>
                  <tr>
                    <td class="center-align" colspan="6">Belum ada data surat</td>
                  </tr>
                <?php endif; ?>
                <div class="card-body">
            <?php echo $this->pagination->create_links(); ?>
          </div>


                </div>
              </div>
            </div>
          </div>