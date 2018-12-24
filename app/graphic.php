<?php 
class my_graphic
{
	/*
	 *big_img:原始大图地址
	 *width:缩略图宽度
	 *height:缩略图高度
	 *small_img:缩略图地址
	 */
	public function img_create_small($big_img, $width, $height, $small_img) {
		$imgage = getimagesize($big_img); //得到原始大图片
		switch ($imgage[2]) { // 图像类型判断
		case 1:
			$im = imagecreatefromgif($big_img);
			break;
		case 2:
			$im = imagecreatefromjpeg($big_img);
			break;
		case 3:
			$im = imagecreatefrompng($big_img);
			break;
		}
		$src_W = $imgage[0]; //获取大图片宽度
		$src_H = $imgage[1]; //获取大图片高度
		$tn = imagecreatetruecolor($width, $height); //创建缩略图
		imagecopyresampled($tn, $im, 0, 0, 0, 0, $width, $height, $src_W, $src_H); //复制图像并改变大小
		imagejpeg($tn, $small_img); //输出图像
	}
   /**
*
* 制作缩略图
* @param $src_path string 原图路径
* @param $max_w int 画布的宽度
* @param $max_h int 画布的高度
* @param $flag bool 是否是等比缩略图  默认为false
* @param $prefix string 缩略图的前缀  默认为'sm_'
*
*/
    public function thumb($src_path,$max_w,$max_h,$prefix = 'sm_',$flag = true){

        //获取文件的后缀
        $ext=  strtolower(strrchr($src_path,'.')); 

        //判断文件格式
        switch($ext){
            case '.jpg':
                $type='jpeg';
                break;
            case '.gif':
                $type='gif';
                break;
            case '.png':
                $type='png';
                break;
            default:
                $this->error='文件格式不正确';
                return false;
        }


        //拼接打开图片的函数
        $open_fn = 'imagecreatefrom'.$type;
        //打开源图
        $src = $open_fn($src_path);
        //创建目标图
        $dst = imagecreatetruecolor($max_w,$max_h);

        //源图的宽
        $src_w = imagesx($src);
        //源图的高
        $src_h = imagesy($src);

        //是否等比缩放
        if ($flag) { //等比
            
            //求目标图片的宽高
            if ($max_w/$max_h < $src_w/$src_h) {

                //横屏图片以宽为标准
                $dst_w = $max_w;
                $dst_h = $max_w * $src_h/$src_w;
            }else{

                //竖屏图片以高为标准
                $dst_h = $max_h;   
                $dst_w = $max_h * $src_w/$src_h;
            }
            //在目标图上显示的位置
            $dst_x=(int)(($max_w-$dst_w)/2);
            $dst_y=(int)(($max_h-$dst_h)/2);
        }else{    //不等比

            $dst_x=0;
            $dst_y=0;
            $dst_w=$max_w;
            $dst_h=$max_h;
        }

        //生成缩略图
        imagecopyresampled($dst,$src,$dst_x,$dst_y,0,0,$dst_w,$dst_h,$src_w,$src_h);

        //文件名
        $filename = basename($src_path);
        //文件夹名
        $foldername=substr(dirname($src_path),0);
        //缩略图存放路径
        $thumb_path = $foldername.'/'.$prefix.$filename;

        //把缩略图上传到指定的文件夹
        imagepng($dst,$thumb_path);
        //销毁图片资源
        imagedestroy($dst);
        imagedestroy($src);

        //返回新的缩略图的文件名
        return $prefix.$filename;
    }

}
}
?>
