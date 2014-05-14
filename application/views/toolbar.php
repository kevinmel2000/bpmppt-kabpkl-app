<?php if ( $load_toolbar ) : ?>
<div class="row action-bar">
    <div class="col-md-12">

    <?php echo set_toolbar( $tool_buttons, $page_link ) ?>

    </div>
    <!-- <div class=" col-md-3"> -->
    
    <?php if( $search_form ) : ?>
        <?php // echo form_search( current_url() ) ?>
    <?php endif ?>

    <!-- </div> -->
</div>
<?php endif ?>