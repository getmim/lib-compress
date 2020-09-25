<?php
/**
 * Compressor handler
 * @package lib-compress
 * @version 0.0.1
 */

namespace LibCompress\Library;

class Compressor
{
	static function brotli(string $file, string $target, int $quality=11): bool{
		$file_mime = mime_content_type($file);

        if(!function_exists('brotli_compress'))
            return false;

		$mode = BROTLI_GENERIC;
		if(preg_match('!\.woff2$!', $file))
			$mode = BROTLI_FONT;
		elseif(strstr($file_mime, 'text'))
			$mode = BROTLI_TEXT;

		$content = file_get_contents($file);
		$compressed = brotli_compress($content, $quality, $mode);
		if(!$compressed)
			return false;

		$f = fopen($target, 'w');
		fwrite($f, $compressed);
		fclose($f);

		return true;
	}

    static function brotliContent(string $content, int $quality=11, int $mode=0): ?string{
        if(!function_exists('brotli_compress'))
            return false;

        if($mode === 0)
            $mode = BROTLI_TEXT;

        $result = brotli_compress($content, $quality, $mode);
        return $result ? $result : null;
    }

	static function gzip(string $file, string $target, string $mode='wb9'): bool{
		if(false === ($fz = gzopen($target, $mode)))
			return false;

		if(false === ($f = fopen($file, 'rb')))
			return false;

		while(!feof($f))
			gzwrite($fz, fread($f, 1024*512));

		fclose($f);
		gzclose($fz);

		return true;
	}

    static function gzipContent(string $content, int $level=9): ?string{
        $result = gzencode($content, $level);
        return $result ? $result : null;
    }

    static function jp2(string $file, string $target, int $quality=40): bool{
    	$file_mime = mime_content_type($file);
    	if(!preg_match('!image\/jpe?g$!', $file_mime))
    		return false;

		$img = new \Imagick($file);
		$img->setImageFormat("jp2");
		$img->setOption('jp2:quality', $quality);
		return $img->writeImage($target);
    }

	static function webp(string $file, string $target, int $quality=90): bool{
		list($width, $height, $type) = getimagesize($file);

		$image_source = null;

		switch($type){
            case IMAGETYPE_JPEG:
                $image_source = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_GIF:
                $image_source = imagecreatefromgif($file);
                break;
            case IMAGETYPE_PNG:
                $image_source = imagecreatefrompng($file);
                break;
        }

        if(!$image_source)
        	return false;

        $dest_image = imagecreatetruecolor($width, $height);
        $background = imagecolorallocate($dest_image, 255, 255, 255);
        imagefilledrectangle($dest_image, 0, 0, $width, $height, $background);
        imageinterlace($dest_image, 1);

        imagecopyresampled($dest_image, $image_source, 0, 0, 0, 0, $width, $height, $width, $height);

        return imagewebp($dest_image, $target, $quality);
	}
}