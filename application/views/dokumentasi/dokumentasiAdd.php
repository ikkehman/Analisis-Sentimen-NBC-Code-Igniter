    <div class="card col-10">
    <div class="card-header">
                      <div class="card-title"><?php echo $pageTitle; ?></div>
                    </div>
      <div class="card-content">
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

        <div class="row mt-3">
          <div class="col-md-12">
            <div class="form-group">
              <label>Judul </label>
              <input required="required" type="text" class="form-control" name="judul" value="" >
            </div>
          </div>  
        </div>

                    <div class="col-md-3">
                      <div class="input-file input-file-image">
                        <img class="img-upload-preview" width="150" src="http://placehold.it/150x150" alt="preview">
                        <input type="file" class="form-control form-control-file" id="uploadImg2" name="featured_img" accept="image/*" required="">
                        <label for="uploadImg2" class=" label-input-file btn btn-icon btn-default btn-round btn-lg"><i class="la la-file-image-o"></i> Upload Cover</label>
                      </div>
                    </div>

                    <div class="form-group">  
          <textarea class="form-control" rows="9" cols="9" id="editordata" name="konten"></textarea>
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
      
    //edtor summernote
    $('#editordata').summernote({
      height: 400,
            //set callback image tuk upload ke serverside
            callbacks: {
                    onImageUpload: function(files) {
                        uploadFile(files[0]);
                    }
                }

    });

    function uploadFile(file) {
            data = new FormData();
            data.append("file", file);

            $.ajax({
                data: data,
                type: "POST",
                url: "<?php echo base_url();?>dokumentasi/saveGambar",
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {                                 
                 console.log(url);                                        
                 $('#editordata').summernote("insertImage", url);
                }
            });
        }

    //input form 
    $('#mydata').submit(function(e){

    e.preventDefault();
     var fa = $(this);

      $.ajax({
        url: fa.attr('action'),
        type: 'post' ,
        data: fa.serialize(),
        dataType: 'json',
        success: function(response) {
          if(response.success == true) {

            $('.form-group').removeClass('is-invalid')
                            .removeClass('is-valid');
            $('.text-danger').remove();
            fa[0].reset();         
            location.reload();

          } else {
            $.each(response.messages,function(key, value){
              var element = $('#' + key);
              element.closest('div.form-group')
              .removeClass('is-invalid')
              .addClass(value.length > 0 ? 'is-invalid' : 'is-valid')
              .find('.text-danger')
              .remove();
              element.after(value);
            });
          }
        }
     });

    });

    });
</script>