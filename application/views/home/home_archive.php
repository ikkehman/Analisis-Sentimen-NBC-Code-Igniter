<div class="breadcumb-area bg-img" style="background-image: url(<?php echo base_url("./assets/img/arsip_img.jpg") ?>);">
<div class="bradcumbContent">
<h2>Arsip Pemilu</h2>
</div>
</div>

<div class="blog-area mt-50 section-padding-100">

<div class="card">
  <div class="card-body" align="center">
    <div class="col-md-10" style="box-shadow: 0 1px 20px 1px rgba(69,65,78,.08)" align="left">
<h1 class="card-title">Data Arsip Pemilu</h1>
<div class="table-responsive">
<table id="multi-filter-select" class="display table table-striped table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nama Dokumen</th>
                <th>Kategori</th>
                <th>Tahun</th>
                <th>Link Download</th>
            </tr>
        </thead>
        <tbody>
          <?php if($arsip): ?>
        <?php $no = $this->uri->segment(3); foreach($arsip as $row): ?>
            <tr>
                <td><?php echo $row->nama_docs; ?></td>
                <td><?php echo $row->kategori; ?></td>
                <td><?php echo $row->tahun_docs; ?></td>
                <td><a href="./assets/files/<?php echo $row->file; ?>"><i class="fas fa-download"></i> Download</a></td>
            </tr>
        <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td class="center-align" colspan="6">Belum ada data</td>
                  </tr>
                <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Nama Dolumen</th>
                <th>Kategori</th>
                <th>Tahun</th>
            </tr>
        </tfoot>
    </table>
                  </div>
                </div>
              </div>
            </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#multi-filter-select').DataTable( {
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select><option value="">Pilih Salah Satu</option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    } );
} );
</script>