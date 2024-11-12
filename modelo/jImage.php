<?php
class jImage {
   var $image;
   var $image_type;
   
   function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
   }
   
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image,$filename);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }   
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }
   
   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }   
   }
   
   function getWidth() {
      return imagesx($this->image);
   }
   
   function getHeight() {
      return imagesy($this->image);
   }
   
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
   
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100; 
      $this->resize($width,$height);
   }
   
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;   
   }
   
   function crop($ancho, $alto)
   {
        $new_image = imagecreatetruecolor($ancho, $alto);
        $src_ancho = $this->getWidth();
        $src_alto = $this->getHeight();
        if($src_ancho > $src_alto)
        {
            $this->resizeToHeight($alto);
            $src_ancho = $this->getWidth();
            $src_x = ($src_ancho/2)-($ancho/2);
            $src_y = 0;
        }
        else
        {
            $this->resizeToWidth($ancho);
            $src_alto = $this->getHeight();
            $src_x = 0;
            $src_y = ($src_alto/2)-($alto/2);
        }
        
        imagecopyresampled($new_image,$this->image,0,0,$src_x,$src_y,$ancho,$alto,$ancho,$alto);
        $this->image = $new_image;
   }
   function crop3($ancho, $alto)
   {
        $new_image = imagecreatetruecolor($ancho, $alto);
        $src_ancho = $this->getWidth();
        $src_alto = $this->getHeight();
        if($src_ancho > $src_alto)
        {   
            $_porcentaje = $alto / $src_alto;             
            $_ancho = $src_ancho * $_porcentaje;
            
            if($_ancho < $ancho)
            {
                $this->resizeToWidth($ancho);
                $src_alto = $this->getHeight();
                $src_x = 0;
                $src_y = ($src_alto/2)-($alto/2);
            }
            else
            {
                $this->resizeToHeight($alto);
                $src_ancho = $this->getWidth();
                $src_x = ($src_ancho/2)-($ancho/2);
                $src_y = 0;    
            }
            
        }
        else
        {
            $_porcentaje = $ancho / $src_ancho;             
            $_alto = $src_alto * $_porcentaje;
            if($_alto < $alto)
            {
                $this->resizeToHeight($alto);
                $src_ancho = $this->getWidth();
                $src_x = ($src_ancho/2)-($ancho/2);
                $src_y = 0; 
            }
            else
            {
                $this->resizeToWidth($ancho);
                $src_alto = $this->getHeight();
                $src_x = 0;
                $src_y = ($src_alto/2)-($alto/2);
            }
        }
        
        imagecopyresampled($new_image,$this->image,0,0,$src_x,$src_y,$ancho,$alto,$ancho,$alto);
        $this->image = $new_image;
   }
   
   function crop2($src_x,$src_y,$ancho, $alto)
   {
        $new_image = imagecreatetruecolor($ancho, $alto);
                
        imagecopyresampled($new_image,$this->image,0,0,$src_x,$src_y,$ancho,$alto,$ancho,$alto);
        $this->image = $new_image;
   }      
}
?>