<?php //$Id$ ?>
<?php 
$fscs = token_replace('[current-user:profile-library-registration:field-library-reg-system]');

$outlets = db_select('square_feet', 's')
      ->fields('s', array('id', 'lib_name', 'sq_feet'))
      ->condition('fscs_key', $fscs)
      ->execute()
      ->fetchAllAssoc('lib_name');
?>

<?php
$sum = 0;
$submit = 0;
$table = "<form name='square_feet' action='imls_data/square_feet/submit' method='post'><table><tr><th>Library Outlet</th><th>Square Feet</th></tr>";
$i = 0;
foreach ($outlets as $outlet) {
	$table .= "<tr>";
	$table .= "<td>$outlet->id</td><td>$outlet->lib_name</td>";
	if ($outlet->sq_feet == -1) {
		$table .= "<td><input type='text' name='$outlet->id'/></td>";
		$submit = 1;
		$i++;
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
	echo $sum; 
	echo $table;
	if($submit) {
		echo "<input type='submit'></form>";
	}
?>
