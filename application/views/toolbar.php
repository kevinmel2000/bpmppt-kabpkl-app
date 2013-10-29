<div id="action-bar" class="row">
	<div class="col-md-9">
		<div class="btn-toolbar">

<?php if( $single_page ) :?>
	<?php $btn_class = ($form_page ? 'btn-default' : 'btn-primary'); ?>
	<div class="btn-group">
		<?php echo anchor( $page_link, $btn_text, 'class="btn '.$btn_class.' btn-sm btn-sm"' ) ?>
	</div>
<?php endif ?>

		</div>
	</div>
	<div class=" col-md-3">
	
<?php if( !$form_page ) :?>
	<div class="input-group input-group-sm">
		<input type="search" class="form-control">
		<span class="input-group-btn">
			<button class="btn btn-default" type="button">Go!</button>
		</span>
	</div><!-- /input-group -->
<?php endif ?>

	</div>
</div>