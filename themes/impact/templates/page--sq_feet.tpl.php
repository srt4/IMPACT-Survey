<?php //$Id$ ?>
<?php 
$fscs = token_replace('[current-user:profile-library-registration:field-library-reg-system]');

$outlets = db_select('square_feet', 's')
      ->fields('s', array('lib_name', 'sq_feet'))
      ->condition('fscs_key', $fscs)
      ->execute()
      ->fetchAllAssoc('lib_name');
?>

<?php
$sum = 0;
$submit = 0;
$table = "<table><tr><th>Library Outlet</th><th>Square Feet</th></tr>";
foreach ($outlets as $outlet) {
	$table .= "<tr>";
	$table .= "<td>$outlet->lib_name</td>";
	if ($outlet->sq_feet == -1) {
		$table .= "<td><input type='text'/></td>";
		$submit = 1;
	} else if ($outlet->sq_feet == -3){
		$table .= "<td>NA</td>";
	} else {
		$table .= "<td>$outlet->sq_feet</td>";
		$sum += $outlet->sq_feet;
	}
	$table .= "</tr>";
}
$table .= "</table>";
?>
sum:
<?php 
	echo $sum; echo $table;
	if($submit) {
		echo "<input type='submit'>";
	}
?>
