<?php echo load_view('header') ?>
<section id="contents">
    <div class="container">
        <?php echo form_alert() ?>
        <div class="row">
            <?php echo $contents ?>
        </div> <!-- .row -->
    </div> <!-- .container-->
</section> <!-- #contents -->
<?php echo load_view('footer') ?>
