<?php $this->EE =& get_instance(); ?>
<table class="mainTable" border="0" cellpadding="0" cellspacing="0">
<thead>
<tr class="header">
	<th><?php echo $this->EE->lang->line('linktracker_linkid') ?></th>
	<th><?php echo $this->EE->lang->line('linktracker_label') ?></th>
	<th><?php echo $this->EE->lang->line('linktracker_clicks') ?></th>
	<th><?php echo $this->EE->lang->line('linktracker_reset') ?></th>
</tr>
</thead>
<tbody>
<?php
$mykeys = array_keys($clicks);
foreach ($mykeys AS $keyname) {	
	$reset_url = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=linktracker'.AMP.'method=reset'.AMP.'link_id='.urlencode($keyname);
	$detail_url = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=linktracker'.AMP.'method=detail'.AMP.'link_id='.urlencode($keyname);
	echo '<tr><td><a href="'.$detail_url.'">'.$keyname.'</a></td><td>'.$label[$keyname].'</td><td>'.$clicks[$keyname].'</td><td><a href="'.$reset_url.'">Reset</a></td></tr>';
}
?>		
</tbody>		
</table>