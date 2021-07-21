<div class="col-md-11">

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
              <div class="card">
          <?php if($message = $this->session->flashdata('message')): ?>
            <div class="col s12">
              <div class="alert <?php echo ($message['status']) ? 'alert-success' : 'alert-danger'; ?>">
                <span class="white-text"><?php echo $message['message']; ?></span>
              </div>
            </div>
          <?php endif; ?>
                <div class="card-header">
                  <div class="card-title"><?php echo $pageTitle; ?></div>
                </div>
                <div class="card-body">
                    <button class="btn btn-danger" onclick="bulk_delete()"><i class="la la-trash-o"></i> Hapus Sekaligus</button>
                    <a href="<?php echo base_url('caleg/add'); ?>" class="btn btn-primary btn-border" style="float: right;">+ Caleg</a>
                  
                  <div class="table-responsive">
                    <hr>
                    <table id="multi-filter-select" class="table table-hover">
                      <thead>
                        <tr>
                          <th><input type="checkbox" id="check-all"></th>
                          <th>No. Urut</th>
                          <th>Nama</th>
                          <th>Jenis Kelamin</th>
                          <th>Partai</th>
                          <th>Dapil</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

</div>

<script type="text/javascript">
var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';
 
$(document).ready(function() {
 

          table = $('#multi-filter-select').DataTable( {
  "pageLength": 10,
  "processing": true,
  "serverSide": true,
  "order": [], //Initial no order.
  "ajax": {
                        "url": '<?php echo base_url()?>caleg/json',
                        "type": "POST",
                                        "dataType": "JSON",
                        },
                        "columns": [
                        {"data": "cek"},
                        {"data": "no_urutcal"},
                        {"data": "nama"},
                        {"data": "jk"},
                        {"data": "nama_partai"},
                        {"data": "nama_dapil"},
                        {"data": "edit"},                        
                    ],
                            //Set column definition initialisation properties.
        "columnDefs": [
            { 
                "targets": [ 0 ], //first column
                "orderable": false, //set not orderable
            },
            { 
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
 
        ],
});
 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
 
 
    //check all
    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });
 
});

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
                data: {id_caleg:list_id},
                url: "<?php echo site_url('caleg/bulk_delete')?>",
                success: function(data)
                {
                    if(data.status)
                    {
                        reload_table();
                    }
                    else
                    {
                        reload_table();
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

<script type="text/javascript" language="JavaScript">
   $(document).ready(function(){
 
 $('#modal-konfirmasi').on('show.bs.modal', function (event) {
  var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
 
  // Untuk mengambil nilai dari data-id="" yang telah kita tempatkan pada link hapus
  var id = div.data('id')
 
  var modal = $(this)
 
  // Mengisi atribut href pada tombol ya yang kita berikan id hapus-true pada modal .
  modal.find('#hapus-true').attr("href","caleg/delete/"+id);
 
 })
 
});
</script>