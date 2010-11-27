<?php 
$link = mysql_connect('localhost', 'wonk', 'wonk');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

$named = $_POST['name'];
$colour = $_POST['colour'];
$id = $_POST['yourId'];

if ($id != 'null') {
$was = sprintf("select * from coalesce.state where id='%s'",
	mysql_real_escape_string($id));

$qs = mysql_query($was);
$row = mysql_fetch_assoc($qs);

if ($named != $row['named']) {
	hey_everyone($row['named'] . ' is now called ' . $named);
}

if ($colour != $row['colour']) {
	hey_everyone($named . ' is now ' . $colour);

	hey_you('sys_shift_left_' . $colour . '_' . $row['colour'], $row['leftId']);
	hey_you('sys_shift_right_' . $colour . '_' . $row['colour'], $row['rightId']);
}

$query = sprintf("update coalesce.state set named='%s', colour='%s' where id='%s')",
    mysql_real_escape_string($named),
    mysql_real_escape_string($colour),
    mysql_real_escape_string($id));
} else {
$query = sprintf("insert into coalesce.state (named, colour) values ('%s', '%s')",
    mysql_real_escape_string($named),
    mysql_real_escape_string($colour));
	$result = mysql_query($query, $link);
	$id = mysql_insert_id($link);
	hey_everyone($named . ' is here!');
}

function hey_you($message, $id) {
	$inner = sprintf("insert into coalesce.messages (userId, message, sent) values(" . $id . ", '%s', false)",
		mysql_real_escape_string($message));
	$inner_result = mysql_query($inner);
}

function hey_everyone($message) {
	$query = 'select id from coalesce.state';
	$result = mysql_query($query);
	
	while ($row = mysql_fetch_assoc($result)) {
	    $id = $row['id'];
		
		$inner = sprintf("insert into coalesce.messages (userId, message, sent) values(" . $id . ", '%s', false)",
			mysql_real_escape_string($message));
		$inner_result = mysql_query($inner);
	}
}
echo $id;
mysql_close($link);
?>