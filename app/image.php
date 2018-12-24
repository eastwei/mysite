<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Images</title>
        <script type="text/javascript" charset="utf-8" src="js/function.js"></script>
    </head>
    <body>
        <p>CLick on an image to view it in a separate window.</p>
        <ul>
        <?php
        // put your code here
        $dir = '../uploads';
        $files = scandir($dir);
        foreach ($files as $image) {
            if (substr($image,0,1)!='.') {
                $image_size = getimagesize("$dir/$image");
                $image_name = urlencode($image);
                echo "<li><a href=\"javascript:"
                . "create_window('$image_name',"
                . "$image_size[0],$image_size[1])\">"
                . "$image</a></li>\n";
                
            }//End of the IF.
        }//End of the foreach loop.
        ?>
    </ul>
    </body>
</html>
