<?php if ( $load_toolbar ) : ?>
<div class="row action-bar">
    <div class="<?php echo twbs_set_columns(12, 12, 12) ?>">

    <?php echo set_toolbar( $tool_buttons, $page_link ) ?>

    </div>
    <!-- <div class=" col-md-3"> -->
    
    <?php if( $search_form ) : ?>
        <?php // echo form_search( current_url() ) ?>
    <?php endif ?>

    <!-- </div> -->
</div>
<?php endif ?>