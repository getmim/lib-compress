<?php
/**
 * Server tester
 * @package lib-compress
 * @version 0.0.1
 */

namespace LibCompress\Server;

class PHP
{
	static function imageMagick(): array{
		$imagick_info = null;

		if(class_exists('Imagick')){
			$imagick_info = \Imagick::getVersion();
			$regex = '!([0-9]+)\.([0-9]+)\.([0-9]+)(?:-([0-9A-Za-z-]+(?:\.[0-9A-Za-z-]+)*))?(?:\+[0-9A-Za-z-]+)?!';

			if(preg_match($regex, $imagick_info['versionString'], $match))
				$imagick_info['versionString'] = $match[0];
		}
		return [
			'success' => !!$imagick_info,
			'info'    => $imagick_info ? $imagick_info['versionString'] : 'Not installed'
		];
	}

	static function imageGD(): array{
		$gd_info = null;
		if(function_exists('gd_info'))
			$gd_info = gd_info();
		return [
			'success' => !!$gd_info,
			'info' => $gd_info ? $gd_info['GD Version'] : 'Not installed'
		];
	}

	static function gdWebP(): array{
		$gd_info = null;
		if(function_exists('gd_info'))
			$gd_info = gd_info();

		return [
			'success' => !!$gd_info,
			'info' => $gd_info['WBMP Support'] ? '-' : 'Not supported'
		];
	}

	static function brotli(): array{
		$support = function_exists('brotli_compress');

		return [
			'success' => $support,
			'info' => $support ? '-' : 'Not installed'
		];
	}

	static function gzip(): array{
		$support = function_exists('gzopen');
		return [
			'success' => $support,
			'info' => $support ? '-' : 'Not installed'
		];
	}
}