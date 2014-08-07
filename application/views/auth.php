<?php echo load_view('header') ?>

<section id="contents">

    <div class="container">

        <?php echo form_alert() ?>

        <div class="row">
            <?php echo $contents ?>
        </div> <!-- .row -->

    </div> <!-- .container-->

</section> <!-- #contents -->

</div> <!-- .wrapper -->

<?php echo load_view('footer') ?>