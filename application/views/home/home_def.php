    <!-- ##### Hero Area Start ##### -->
    <section class="hero-area">
        <div class="hero-slides owl-carousel">

            <!-- Single Hero Slide -->
            <div class="single-hero-slide bg-img" style="background-image: url(<?php echo base_url("assets/img/header4.jpg") ?>); max-height: 600px">
            </div>


            <!-- Single Hero Slide -->
            <div class="single-hero-slide bg-img" style="background-image: url(<?php echo base_url("assets/img/header2.jpg") ?>); max-height: 600px">
            </div>
        </div>
    </section>
    <!-- ##### Hero Area End ##### -->

        <!-- ##### Top Feature Area Start ##### -->
    <div class="top-features-area wow fadeInUp" data-wow-delay="300ms">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="features-content">
                        <div class="row no-gutters">
                            <!-- Single Top Features -->
                            <div class="col-12 col-md-12">
                                <div class="single-top-features d-flex align-items-center justify-content-center">
                            <div class="form-group col-md-6">
                            <h5>Lihat Hasil Pemilu</h5>
                            <select id="kategori" name="kategori" required="" class="form-control" >
                              <option value="" disabled selected>-Pilih Dapil-</option>
                              <?php foreach ($dapil->result() as $d) {echo "<option value='$d->id_dapil'>$d->nama_dapil</option>";}?>
                            </select> 
                          </div>
                          <button id="btn" class="btn btn-light">Lihat</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- ##### Top Feature Area End ##### -->

    <div class="blog-area mt-50">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="academy-blog-posts">
                        <div class="row">

<!--xxxxxxxxxxx-->
                        <?php if($dokumentasi): ?>
                  <?php $no = $this->uri->segment(3); foreach($dokumentasi as $row): ?>
                                                <!-- Single Blog Start -->
                            <div class="col-6">
                                <div class="single-blog-post mb-50 wow fadeInUp" data-wow-delay="300ms" style="visibility: visible; animation-delay: 300ms; animation-name: fadeInUp;">
                                    <!-- Post Thumb -->
                                    <div class="blog-post-thumb mb-50">
                                        <img src="<?php echo base_url("assets/images/".$row->featured_img)?>" alt="" style="max-height: 320px;">
                                    </div>
                                    <!-- Post Title -->
                                    <a href="<?php echo base_url("dokumentasi/post/").$row->id_dokumentasi?>" class="post-title"><?php echo $row->judul; ?></a>
                                    <!-- Post Meta -->
                                    <div class="post-meta">
                                        <p>By <?php echo $row->author; ?> | <?php echo  $newDate = date("d F Y", strtotime($row->tanggal_rilis)); ?></p>
                                    </div>
                                    <!-- Read More btn -->
                                    <a href="#" class="btn academy-btn btn-sm mt-15">Read More</a>
                                </div>
                            </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td class="center-align" colspan="6">Belum ada data post</td>
                  </tr>
                <?php endif; ?>
<!--xxxxxxxxxxx-->
                        </div>
                    </div>
                    <!-- Pagination Area Start -->
                    <div class="academy-pagination-area wow fadeInUp" data-wow-delay="400ms" style="visibility: hidden; animation-delay: 400ms; animation-name: none;">
                        <nav>
                                <?php echo $this->pagination->create_links(); ?>
                        </nav>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="academy-blog-sidebar">
                </div>
            </div>
        </div>
    </div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
$('#btn').click(function () {
var cid = $('#kategori option:selected').val();
var url = '<?php echo base_url("home/result") ?>/'+ cid;
window.location = url;
});
</script>