<sytle>
div {
text-align:center;
border:2px solid black;
padding:5px;
margin:10px;
}

ul {
font-size:9px;
text-align:left;
}
</sytle>
<?php
/*create thumbnail*/
$path = "../uploads/";
$do = dir($path);

while(($file = $do->read()) !== false) {
	$info = pathinfo($path . $file);
	if(strtolower($info['extension']) == 'jpg') {
		echo "<div><a  href=\"{$path}{$file}\">";
		if($thumb = exif_thumbnail($path . $file, $width, $height, $type)){
			$mime = image_type_to_mime_type($type);
			$encoded = base64_encode($thumb);
			echo "<img src=\"data:{$mime};base64,{$encoded}\"/><br />";
		}
		echo $file, "</a>\n";
		if($exif = exif_read_data($path . $data)) {
			foreach($exif as $section => $sectiondata) {
				if(is_array($sectiondata)) {
					echo "<li>{section}<ul>\n";
					foreach($sectiondata as $name => $data) {
						echo "<li>{$name}=",htmlspecialchars($data),"</li>\n";
					}
					echo"</ul></li>\n";
				}else {
					echo"<li>{sectiondata}=", htmlspecialchars($sectiondata),"</li>\n";
				}
			}
			echo"</ul>\n";
		}
		echo "</div>\n";
	}
}
?>
