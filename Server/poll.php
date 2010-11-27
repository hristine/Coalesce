<?php 
$link = mysql_connect('localhost', 'wonk', 'wonk');
if (!$link) {
    die('Could not connect: ' . mysql_error());
} 

$id = $_POST['yourId'];

$query = sprintf("select * from coalesce.messages where userId=('%s') and sent = false",
    mysql_real_escape_string($id));
    
$result = mysql_query($query, $link);

$queryForMe = sprintf("select * from coalesce.state where id='%s'",
	mysql_real_escape_string($id));
$me = mysql_query($queryForMe);
$merow = mysql_fetch_assoc($me);

echo '{';
echo '"left":"' . $merow['leftId'] . '",';
echo '"right":"' . $merow['rightId'] . '",';
echo '"messages": [';
$first = true;
while ($row = mysql_fetch_assoc($result)) {
	if (!$first) echo ', ';
    echo '"' . $row['message'] . '"';
    $first = false;
    
    $inner = sprintf("update coalesce.messages set sent = true where id = '%s'",
    	mysql_real_escape_string($row['id']));
    mysql_query($inner);
}
echo '], ';

$everyone = 'select * from coalesce.state';
$everyoneqs = mysql_query($everyone);

$first = true;
echo '"everyone": {';
while ($row = mysql_fetch_assoc($everyoneqs)) {
	if (!$first) echo ',';
	echo '"' . $row['id'] . '": "' . $row['named'] . '"';
	
	$first = false;
}
echo '}';

echo '}';

mysql_close($link);
?>