<?php 
$link = mysql_connect('localhost', 'wonk', 'wonk');
if (!$link) {
    die('Could not connect: ' . mysql_error());
} 

$id = $_POST['yourId'];

$query = sprintf("select * from coalesce.messages where userId=('%s') and sent = false",
    mysql_real_escape_string($id));
    
$result = mysql_query($query, $link);

echo '{"messages": [';
$first = true;
while ($row = mysql_fetch_assoc($result)) {
	if (!$first) echo ', ';
    echo '"' . $row['message'] . '"';
    $first = false;
    
    $inner = sprintf("update coalesce.messages set sent = true where id = '%s'",
    	mysql_real_escape_string($row['id']));
    mysql_query($inner);
}
echo ']}';

mysql_close($link);
?>