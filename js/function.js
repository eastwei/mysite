/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function create_window (image,width,height) {
    //Add some pixels to the width and height:
    width = width + 10;
    height = height + 10;
    
    if (window.popup && !window.popup.closed) {
        window.popup.resizeTo(width,height);
    }
    var specs ="location=no,scrollbars=no,menubars=no,toolbars=no\n\
     resizable=yes, left=0,top=0,width=" + width + ",height="+height;
    var url = "show_image.php?image=" + image;
    
    popup = window.open(url,"ImageWindow",specs);
    popup.focus();
}

