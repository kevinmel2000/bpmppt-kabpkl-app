<?php echo load_view('header') ?>

<section id="contents">
    <div class="container">
        <?php echo form_alert() ?>
        <?php $nav = get_nav('side', TRUE) ?>

        <div class="row">
            <section id="main-content" class="<?php echo ($nav ? twbs_set_columns(9, 9, 12, 12, 12) : twbs_set_columns(12, 12, 12)) ?>">
                <button id="sidebar-toggle" type="button" class="btn btn-default">
                    <span class="fa fa-bars">
                </button> <!-- .sidebar-toggle -->
                <?php echo $contents ?>
            </section> <!-- #main-content -->

        <?php if ($nav): ?>
            <aside id="sidebar" class="collapse <?php echo twbs_set_columns(3, 3, 12, 12, 12) ?>">
                <div id="sidebar-backdrop"></div>
                <?php echo $nav ?>
            </aside> <!-- #sidebar -->
        <?php endif ?>
        </div> <!-- .row -->
    </div> <!-- .container-->
</section> <!-- #contents -->

<?php echo load_view('footer') ?>
