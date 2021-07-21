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

  <!-- modal input-->
<div id="modal-input" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content">
 
   <div class="modal-header">
    <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Masukan Nama Sektor</h4>
   </div>

           <form id="add-user-form" method="post" action="<?php echo base_url().'/sektor/tambah'?>">
                <div class="form-group">
                  <label for="nama_sektor">Nama Sektor</label>
                  <input type="text" class="form-control" required="" name="nama_sektor" id="nama_sektor" value="">
                </div>

 
   <div class="modal-footer">
                  <button type="submit" name="submit" value="login" class="btn btn-success">Simpan</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
   </div>
 </form>
  </div>
 </div>
</div>

  <!-- modal edit-->
      <?php
        foreach($sektor->result_array() as $i):
            $id_sektor=$i['id_sektor'];
            $nama_sektor=$i['nama_sektor'];
      ?>
<div id="modal-edit<?php echo $id_sektor;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content">
 
   <div class="modal-header">
    <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Masukan Nama Sektor</h4>
   </div>

           <form id="add-user-form" method="post" action="<?php echo base_url().'/sektor/edit/'?><?php echo $id_sektor;?>">
                <div class="form-group">
                  <label for="nama_sektor">Kode Kejuruan</label>
                  <input type="text" class="form-control" required="" name="nama_sektor" id="nama_sektor" value="<?php echo $nama_sektor;?>">
                </div>

 
   <div class="modal-footer">
                  <button type="submit" name="submit" value="login" class="btn btn-success">Simpan</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
   </div>
 </form>
  </div>
 </div>
</div>
<?php endforeach;?>

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
                    <a href="javascript:;" data-toggle="modal" data-target="#modal-input" class="btn btn-primary btn-border" style="float: right;">+ Sektor</a>
                    <button class="btn btn-danger" onclick="bulk_delete()"><i class="la la-trash-o"></i> Hapus Sekaligus</button>                  
                  <div class="table-responsive">
                    <hr>
                    <table id="multi-filter-select" class="table table-hover">
                      <thead>
                        <tr>
                          <th><input type="checkbox" id="check-all"></th>
                          <th>No. Sektor</th>
                          <th>Sektor</th>
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
                        "url": '<?php echo base_url()?>sektor/json',
                        "type": "POST",
                                        "dataType": "JSON",
                        },
                        "columns": [
                        {"data": "cek"},
                        {"data": "id_sektor"},
                        {"data": "nama_sektor"},
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
                data: {id_sektor:list_id},
                url: "<?php echo site_url('sektor/bulk_delete')?>",
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
  modal.find('#hapus-true').attr("href","sektor/delete/"+id);
 
 });


 $('#modal-input').on('show.bs.modal', function (event) {
  var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
 
  // Untuk mengambil nilai dari data-id="" yang telah kita tempatkan pada link hapus
  var id = div.data('id')
 
  var modal = $(this)
 
  // Mengisi atribut href pada tombol ya yang kita berikan id hapus-true pada modal .
  modal.find('#save-true').attr("href","sektor/tambah/");
 
 })
 
});
</script>