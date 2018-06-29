<?php
/**
 * Server tester
 * @package lib-compress
 * @version 0.0.1
 */

namespace LibCompress\Server;

class PHP
{
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