<?php if( $this->session->userdata('id') ) $this->load->view('site/ambiance/sections/form') /* Check if the user is logged in */ ?>
<?php echo $breadcrumbs; ?>
<!-- black overlay -->
<div class="overlay upload-page-popup" ></div>

<!-- pop-up section to receive content -->
<section class="pop-block-extended"></section>

<input id="ambiances-result-count" type="hidden" value="<?php echo  $ambiances->count() ?>">
<input id="ambiances-result-limit" type="hidden" value="<?php echo  $resultLimit ?>">

<div class="container_12 content ambiance">
    <section class="upload-image container_12">
        <div id="ambiance-objects">
            <?php $this->load->view('site/ambiance/sections/content') ?>
        </div>
    </section>
</div>
