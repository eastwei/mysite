<?php
$files = array();

$d = dir('../uploads');

while (false !== ($file = $d->read())) {
	if ( ($file{0} != '.') &&
		 ($file{1} != '~') &&
		 (substr($file, -3) != 'LCK') &&
		 ($file != basename($_SERVER['PHP_SELF'])) ) {
			 $files[$file] = stat($file);
		 }
}

$d->close();

echo '<style>td { padding-right: 10px;}</style>';
echo '<table><caption>The contents of this directory:</caption>';

ksort($files);

date_default_timezone_set('China/Shang_Hai');

foreach($files as $name => $stats) {
	echo "<tr><td><a href=\"{$name}\">{$name}</a></td>\n";
	echo "<td align='right'>{$stats['size']}</td>\n";
	echo '<td>',date('m-d-Y h:ia',$stats['mtime']),"</td></tr>\n";
}
echo '</table>';
?>
