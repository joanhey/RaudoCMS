<?php

class _img
{    
    static function makeThumb( $src, $dest, $desired_width, $desired_height='' )
    {
        $extension = explode( '.', $src );
        $extension = end( $extension );
        $imagecreate = "imagecreatefrom$extension";
        $image = "image$extension";
        
        /* read the source image */
        $source_image = $imagecreate( $src );
        $width = imagesx( $source_image );
        $height = imagesy( $source_image );
        
        /* find the "desired height" of this thumbnail, relative to the desired width  */
        if ( ! $desired_height ) $desired_height = floor( $height * ( $desired_width / $width ) );
        
        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor( $desired_width, $desired_height );
        
        /* copy source image at a resized size */
        imagecopyresampled( $virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height );
        #imagecopyresized( $virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height );
        
        /* create the physical thumbnail image to its destination */
        $image( $virtual_image, $dest );
    }
    
    static function eicon( $x, $y, $class='' )
    {
        if ( $x % 2 )
        {
            $x = ( 23 * ($x-1) ) . 'px';
            $y = ( 26 * ($y-1) + 6 ) . 'px';
            $w = '11px';
            $h = '11px';
        }
        else
        {
            $x = ( 23 * ($x-1) - 3 ) . 'px';
            $y = ( 26 * ($y-1) ) . 'px';
            $w = '17px';
            $h = '17px';
        }
        /*$x = ( $x * 22.5 - 22.5 ) . 'px';
        $y = ( $y * 25.55 - 25.55 ) . 'px';*/
        
        if ( $class ) $class=" class=\"$class\"";
        
        echo "<span$class style=\"float:left; width:$w; height:$h; background:url( '/img/icons.png' ) -$x -$y\"></span>";	
    }
}

