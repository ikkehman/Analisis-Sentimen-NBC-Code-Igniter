<div class="breadcumb-area bg-img" style="background-image: url(<?php echo base_url("assets/images/".$dokumentasi->featured_img) ?>);">
<div class="bradcumbContent">
<h2>Dokumentasi Pemilu</h2>
</div>
</div>

<div class="blog-area mt-50 section-padding-100">

<div class="card">
  <div class="card-body" align="center">
    <div class="col-md-10" style="box-shadow: 0 1px 20px 1px rgba(69,65,78,.08)" align="left">
<div class="col-12">
<div class="single-blog-post mb-50 wow fadeInUp" data-wow-delay="300ms" style="visibility: visible; animation-delay: 300ms; animation-name: fadeInUp; background-color:ffffff;">

<a href="<?php echo base_url().$dokumentasi->id_dokumentasi; ?>" class="post-title"><?php echo $dokumentasi->judul; ?></a>

<div class="post-meta">
<p>By <?php echo $dokumentasi->author; ?> | <?php echo  $newDate = date("d F Y", strtotime($dokumentasi->tanggal_rilis)); ?></p>
</div>

<?php echo $dokumentasi->konten; ?>


</div>
                </div>
              </div>
            </div>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>