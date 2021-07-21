<style type="text/css">
.ikkeh a {
  color: black;
  text-decoration: none;
}

.geser
{
  padding-right: 10px;
}
</style>
<div class="mail-wrapper">

  <!-- modal konfirmasi-->
<div id="modal-konfirmasi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content">
 
   <div class="modal-header">
    <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Konfirmasi</h4>
   </div>
 
   <div class="modal-body btn-info">
    Apakah Anda yakin ingin menghapus data ini?
   </div>
 
   <div class="modal-footer">
    <a href="javascript:;" class="btn btn-danger" id="hapus-true">Ya</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
   </div>
 
  </div>
 </div>
</div>

            <div class="mail-content">
            <?php if($message = $this->session->flashdata('message')): ?>
            <div class="col s12">
              <div class="alert <?php echo ($message['status']) ? 'alert-success' : 'alert-danger'; ?>">
                <span class="white-text"><?php echo $message['message']; ?></span>
              </div>
            </div>
          <?php endif; ?>
              <div class="inbox-head">
                <h3><?php echo $pageTitle; ?></h3>
                <form action="<?php echo base_url('berita/cari'); ?>" class="ml-auto" method="post">
                  <div class="input-group">
                    <input type="text" name="key" placeholder="Cari berita..." class="form-control">
                    <div class="input-group-append">
                      <button type="submit" class="btn input-group-text">
                        <i class="la la-search search-icon"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="inbox-body">
<?php if($this->session->userdata('level') == 'pengawas'): ?>
                <div class="mail-option">
                  <div class="row email-filters-left">
                  <div class="card-title geser">
                    <button onclick="bulk_delete()" class="btn btn-danger btn-border" style="float: right;"><i class="la la-trash-o"></i>Hapus berita</button>
                  </div>
                  <div class="card-title">
                    <a href="<?php echo base_url('berita/add'); ?>" class="btn btn-primary btn-border" style="float: right;"><i class="la la-plus"></i> Tambah berita</a>
                  </div>
                  </div>
                </div>
<?php endif; ?>

                <div class="email-list">
                  <?php if($berita): ?>
                  <?php $no = $this->uri->segment(3); foreach($berita as $row): ?>

                  <div class="email-list-item unread">
                    <div class="email-list-actions">
                      <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="data-check
                        custom-control-input" value="<?php echo $row->id_berita; ?>">
                        <span class="custom-control-label"></span>
                      </label><a href="<?php echo base_url('berita/lihat/' . $row->id_berita); ?>" class="favorite active"></a>
                    </div>
                    <div class="email-list-detail ikkeh">
                      <a href="<?php echo base_url('berita/lihat/' . $row->id_berita); ?>">

                      <div class="col-sm-4 float-right">
                      <span class="date float-right">
                        <?php if($row->lampiran !== ''): ?>
                        <i class="la la-paperclip paperclip"></i>
                        <?php endif; ?>
                        <?php echo tgl_indo("Y-m-d",strtotime($row->tgl_berita)).', '.date("H:i",strtotime($row->tgl_berita)); ?></span>
                        </div>


                        <span class="from"><?php echo $row->pengirim; ?></span>
                      <p class="msg"><?php echo $row->subjek; ?></p>
                    </a>
                    </div>
                  </div>
                  <?php endforeach; ?>

                  <?php else: ?>
                  <tr>
                    <td class="center-align" colspan="6">Belum ada data berita</td>
                  </tr>
                <?php endif; ?>
                <div class="card-body">
            <?php echo $this->pagination->create_links(); ?>
          </div>


                </div>
              </div>
            </div>
          </div>

<script type="text/javascript">
var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}
 
function bulk_delete()
{
    var list_id = [];
    $(".data-check:checked").each(function() {
            list_id.push(this.value);
    });
    if(list_id.length > 0)
    {
        if(confirm('Anda yakin menghapus '+list_id.length+' data?'))
        {
            $.ajax({
                type: "POST",
                data: {id_berita:list_id},
                url: "<?php echo site_url('berita/bulk_delete')?>",
                success: function(data)
                {
                    if(data.status)
                    {
                        location.reload();
                    }
                    else
                    {
                        location.reload();
                    }
                     
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
        }
    }
    else
    {
        alert('Pilih data yang akan dihapus teelebih dahulu.');
    }
}
 
</script>