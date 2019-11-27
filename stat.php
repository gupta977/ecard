<?php
function odudecard_stat_page()
{
	
	
	?>
	<div class="wrap">
	<h2>statistics</h2>
	
<?php
	global $wpdb;
	echo '<h3>';
	echo __('Last 50 Ecards Sent','odudecard');
	echo '</h3>';
	$query="SELECT * FROM ".$wpdb->prefix."odudecard_view WHERE status='Y' order by id desc	limit 0,50";
	$cron_cards = $wpdb->get_results($query);
	
	
	if($cron_cards)
	{
		echo '<table class="pure-table pure-table-horizontal">
    <thead>
        <tr>
            <th>ID</th>
            <th>Sender Name</th>
            <th>Sender Email</th>
            <th>Receiver Name</th>
			<th>Receiver Email</th>
			<th>Subject</th>
        </tr>
    </thead>

    <tbody>';
	
		foreach($cron_cards as $card)
		{
			echo '<tr>
            <td>'.$card->id.'</td>
            <td>'.$card->SN.'</td>
            <td>'.$card->SE.'</td>
            <td>'.$card->RN.'</td>
			<td>'.$card->RE.'</td>
			<td>'.$card->sub.'</td>
        </tr>';
		}
		
	echo '</tbody>
</table>';	
	}
	echo '<h3>';
	echo __('Next 50 Ecards Pending','odudecard');
	echo '</h3>';
	$query="SELECT * FROM ".$wpdb->prefix."odudecard_view WHERE status='N' order by clock desc	limit 0,50";
	$cron_cards = $wpdb->get_results($query);
	
	
	if($cron_cards)
	{
		echo '<table class="pure-table pure-table-horizontal">
    <thead>
        <tr>
            <th>ID</th>
            <th>Sender Name</th>
            <th>Sender Email</th>
            <th>Receiver Name</th>
			<th>Receiver Email</th>
			<th>Subject</th>
			<th>schedule Date</th>
        </tr>
    </thead>

    <tbody>';
	
		foreach($cron_cards as $card)
		{
			echo '<tr>
            <td>'.$card->id.'</td>
            <td>'.$card->SN.'</td>
            <td>'.$card->SE.'</td>
            <td>'.$card->RN.'</td>
			<td>'.$card->RE.'</td>
			<td>'.$card->sub.'</td>
			<td>'.$card->clock.'</td>
        </tr>';
		}
		
	echo '</tbody>
</table>';	
	}
?>
	</div>
	
	
	<?php
}

?>