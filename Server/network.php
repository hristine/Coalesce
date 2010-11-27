<?php 
$link = mysql_connect('localhost', 'wonk', 'wonk');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

$side = $_POST['side'];
$id = $_POST['yourId'];
$theirs = $_POST['id'];

if ($side == 'left') {
$query = sprintf("update coalesce.state set leftId=%s where id=%s",
    mysql_real_escape_string($theirs),
    mysql_real_escape_string($id));
} else {
$query = sprintf("update coalesce.state set rightId=%s where id=%s",
    mysql_real_escape_string($theirs),
    mysql_real_escape_string($id));
}

mysql_query($query);
echo $query;
?>