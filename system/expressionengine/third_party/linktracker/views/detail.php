<?php $this->EE =& get_instance(); ?>
<table class="mainTable" border="0" cellpadding="0" cellspacing="0">
<thead>
<tr>
<tr class="header">
	<th><?php echo $this->EE->lang->line('linktracker_date') ?></th>
	<th><?php echo $this->EE->lang->line('linktracker_label') ?></th>
	<th><?php echo $this->EE->lang->line('linktracker_linktarget') ?></th>
	<th><?php echo $this->EE->lang->line('linktracker_linkorigin') ?></th>
	<th><?php echo $this->EE->lang->line('linktracker_ip') ?></th>
</tr>
</thead>
<tbody>
<?php
$i = 0;
foreach ($clicks as $value) {
	echo '<tr>
		<td>'.$clicks[$i]["id"].'</td>
		<td>'.$clicks[$i]["label"].'</td>
		<td>'.$clicks[$i]["target"].'</td>
		<td>'.$clicks[$i]["url"].'</td>
		<td>'.$clicks[$i]["ip"].'</td>
		</tr>';
		$i++;
}
?>		
</tbody>		
</table>