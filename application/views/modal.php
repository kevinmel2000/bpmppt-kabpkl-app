<?php echo form_open( $link . '/submit_' . ( $what ? 'nilai' : 'group' ) . '/' . ( $id ? $id : '' ), $form_attr);?>

<div class="modal-body">

<?php if ($what) : ?>

	<div id="control_input_name" class="control-group">
		<label class="control-label" for="input_name">Group Properti</label>
		<div class="controls">
			<?php echo form_dropdown($input_name['name'], $input_name['option'], $input_name['value'], $input_name['attr']);?>
		</div>
	</div>
	
	<div id="control_input_value" class="control-group">
		<label class="control-label" for="input_value">Nilai Property</label>
		<div class="controls">
			<?php echo form_input($input_value);?>
		</div>
	</div>
	
	<div id="control_input_slug" class="control-group">
		<label class="control-label" for="input_slug">Nama Singkat</label>
		<div class="controls">
			<?php echo form_input($input_slug);?>
		</div>
	</div>

<?php else: ?>
	
	<div id="control_input_label" class="control-group">
		<label class="control-label" for="input_label">Label Group Properti</label>
		<div class="controls">
			<?php echo form_input($input_label);?>
		</div>
	</div>

	<div id="control_input_name" class="control-group">
		<label class="control-label" for="input_name">Nama Group Properti</label>
		<div class="controls">
			<?php echo form_input($input_name);?>
		</div>
	</div>

	<?php if($id=='') : ?>
	
	<div id="control_input_value" class="control-group">
		<label class="control-label" for="input_value">Nilai Property</label>
		<div class="controls">
			<?php echo form_input($input_value);?>
		</div>
	</div>
	
	<div id="control_input_slug" class="control-group">
		<label class="control-label" for="input_slug">Nama Singkat</label>
		<div class="controls">
			<?php echo form_input($input_slug);?>
		</div>
	</div>

	<?php endif; ?>

<?php endif; ?>

</div>
<div class="modal-footer">
<?php
if (strlen($id)>0) {
	if($what) {
		echo anchor( $link.'/hapus_nilai/'.$id,'Hapus','class="btn btn-danger btn-hapus pull-left"  title="'.$input_value['value'].'"');
	} else {
		echo anchor( $link.'/hapus_group/'.$id,'Hapus','class="btn btn-danger btn-hapus pull-left"  title="'.$input_name['value'].'"');
	}
}

	echo form_submit($input_submit);
	echo form_reset(array('name'=>'reset','value'=>'Batal','class'=>'btn','data-dismiss'=>'modal','aria-hidden'=>'true'));
?>
</div>

<?php echo form_close();?>