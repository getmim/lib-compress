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

	static function webp(string $file, string $target, int $quality=90): bool{
		list($width, $height, $type) = getimagesize($file);

		$image_source = null;

		switch($type){
            case IMAGETYPE_GIF:
                $image_source = imagecreatefromgif($file);
                break;
            case IMAGETYPE_JPEG:
                $image_source = imagecreatefromjpeg($file);
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