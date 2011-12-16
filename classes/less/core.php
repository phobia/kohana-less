<?php defined('SYSPATH') or die('No direct script access.');

class Less_Core
{
	// Default less files extension
	public static
		$ext = '.less',
		$config;
	
	
	public static function compile($files, $media = 'screen') {
		$stylesheets = array();

		if (!is_array($files)) {
		    $files = array($files);
		}
		
		self::$config = Kohana::$config->load('less');

		foreach($files as $file) {
		    $stylesheets[] = self::compile_file($file, self::generate_filename($file));
		}
		
		return self::generate_links($stylesheets, $media);
	}

	
	private static function generate_filename($file) {
		$info = pathinfo($file);
		return self::$config['path'].$info['filename'].'.css';
	}


	private static function compile_file($less_fname, $css_fname) {
		$cache_fname = $css_fname.".cache";
		if (file_exists($cache_fname)) {
			$cache = unserialize(file_get_contents($cache_fname));
		} else {
			$cache = $less_fname;
		}
	        $recompile = self::$config['always_recompile'];
		$new_cache = lessc::cexecute($cache, $recompile);
		if (!is_array($cache) || $new_cache['updated'] > $cache['updated']) {
			if(self::$config['compress']) {
				$new_cache['compiled'] = self::compress($new_cache['compiled']);
			}
			file_put_contents($cache_fname, serialize($new_cache));
			file_put_contents($css_fname, $new_cache['compiled']);
		}
		
		return $css_fname;
	}

	
	/**
	 * Generate string with <link> to the various stylesheets
	 * @param array $files
	 * @param string $media Value for the media attribute of the link element
	 * @return string
	 */
	private static function generate_links($files, $media = 'screen') {
		$stylesheets = array();
		$link = '<link rel="stylesheet" type="text/css" href="/%s" media="%s" />';

		foreach($files as $file) {
			$stylesheets[] = sprintf($link, $file, $media);
		}

		return implode(PHP_EOL, $stylesheets);
	}


	/**
	 * Compress the css file
	 *
	 * @param   string   css string to compress
	 * @return  string   compressed css string
	 */
	private static function compress($data)
	{
		$data = preg_replace('~/\*[^*]*\*+([^/][^*]*\*+)*/~', '', $data);
		$data = preg_replace('~\s+~', ' ', $data); //Remove whitespace
		$data = preg_replace('~ *+([{}+>:;,]) *~', '$1', trim($data));
		$data = str_replace(';}', '}', $data);
		$data = preg_replace('~[^{}]++\{\}~', '', $data);

		return $data;
	}

	
	/**
	 * Format string to HTML comment format
	 *
	 * @param   string   string to format
	 * @return  string   HTML comment
	 */
	protected static function _html_comment($string = '')
	{
		return '<!-- '.$string.' -->';
	}
	
}