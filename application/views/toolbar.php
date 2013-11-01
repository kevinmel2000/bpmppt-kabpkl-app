<?php if ( $load_toolbar ) : ?>
<div id="action-bar" class="row">
	<div class="col-md-9">

	<?php echo set_toolbar( $tool_buttons ) ?>

	</div>
	<div class=" col-md-3">
		
	<?php if( $search_form ) :?>
		<?php echo form_search( current_url() ) ?>
	<?php endif ?>

	</div>
</div>
<?php endif ?>