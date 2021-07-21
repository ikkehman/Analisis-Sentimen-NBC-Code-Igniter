    <div class="card col-10">
    <div class="card-header">
                      <div class="card-title"><?php echo $pageTitle; ?></div>
                    </div>
      <div class="card-content">
        <form id="add-user-form" method="post" enctype="multipart/form-data" action="">
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

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Dari</label>
              <input required="required" type="text" readonly class="form-control" name="" value="<?php echo($this->session->userdata('nama')) ?>">
            </div>
          </div>           
        </div>

        <input name="pengirim" type="text" class="form-control" required="" hidden value="<?php echo($this->session->userdata('username')) ?>">

          <div class="form-group col-md-12 select2-input">
              <label for="exampleFormControlSelect1">Pelanggaran</label>
              <select required="required" id="pendaftar" name="no_pelanggaran" class="form-control">
                <option value="" disabled selected>- Pilih Pelanggaran -</option>
                <?php foreach ($pelanggaran->result() as $w) {echo "<option value='$w->id_pelanggaran'>&quot;$w->nama_perusahaan&quot; melanggar $w->nama_norma - ". tgl_indo($w->tgl_pelang) . "</option>";}?>
              </select>
            </div>

          <div class="col-md-12">
            <div class="form-group">
              <label>Perihal</label>
              <input required="required" type="text" class="form-control" name="subjek" value="">
            </div>
          </div> 

            <div class="form-group">
              <textarea class="form-control" id="summernote" name="desk" rows="3"></textarea>
            </div>

<div class="custom-file">
    <input type="file" name="lampiran" class="custom-file-input" id="customFile">
    <label class="custom-file-label" for="customFile">Pilih File</label>
</div>

        </div>

        <div class="row" style="padding-bottom: 20px;">
              <button type="submit" name="submit" value="login" class="btn btn-success">Simpan</button>
          </div>

        </form>
      </div>
    </div>

<script src="<?php echo base_url('assets/js/core/jquery.3.2.1.min.js'); ?>"></script>
<script>

  $(document).ready(function(){
        $('#basic').select2({
    theme: "bootstrap"
  });

  $('#multiple').select2({
    theme: "bootstrap"
  });
    });
$('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
});
</script>

  <!--- Buat Dapat Nomor HP -->
<script type="text/javascript">     
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ( (charCode > 31 && charCode < 48) || charCode > 57) {
        return false;
    }
        return true;
}
</script>


<script type="text/javascript">
$(function() {
  // main summernote with custom placeholder
  var $placeholder = $('.placeholder');
  $('#summernote').summernote({
    height: 300,
    codemirror: {
      mode: 'text/html',
      htmlMode: true,
      lineNumbers: true,
      theme: 'monokai'
    },
    callbacks: {
      onInit: function() {
        $placeholder.show();
      },
      onFocus: function() {
        $placeholder.hide();
      },
      onBlur: function() {
        var $self = $(this);
        setTimeout(function() {
          if ($self.summernote('isEmpty') && !$self.summernote('codeview.isActivated')) {
            $placeholder.show();
          }
        }, 300);
      }
    }
  });
});
</script>