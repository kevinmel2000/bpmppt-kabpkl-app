<?php echo load_view('header') ?>

<section id="contents">

    <div class="container">

        <?php echo form_alert() ?>

        <?php $nav = get_nav('side', TRUE) ?>

        <div class="row">

            <section id="main-content" class="<?php echo ($nav ? twbs_set_columns(9, 9, 11) : twbs_set_columns(12, 12, 12)) ?>">
                <?php echo $contents ?>
            </section> <!-- #main-content -->

        <?php if ($nav): ?>

            <aside id="sidebar" class="<?php echo twbs_set_columns(3, 3, 1) ?>">
                <?php echo $nav ?>
            </aside> <!-- #sidebar -->

        <?php endif ?>

        </div> <!-- .row -->

    </div> <!-- .container-->

</section> <!-- #contents -->

</div> <!-- .wrapper -->

<?php if ( $need_print ) : ?>

<applet id="qz" name="QZ Print Plugin" code="qz.PrintApplet.class" width="55" height="55">

    <param name="jnlp_href" value="qz-print_jnlp.jnlp">
    <param name="cache_option" value="plugin">

</applet>

<?php endif ?>

<?php echo load_view('footer') ?>