<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter CAPTCHA Helper
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/xml_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Create CAPTCHA
 *
 * @access	public
 * @param	array	array of data for the CAPTCHA
 * @param	string	path to create the image in
 * @param	string	URL to the CAPTCHA image folder
 * @param	string	server path to font
 * @return	string
 */
if ( ! function_exists('create_captcha'))
{
	define('CODE_WIDTH',         120);
	define('CODE_HEIGHT',        30);
	define('CODE_FONT_SIZE',     15);
	define('CODE_CHARS_COUNT',   5);
	define('CODE_LINES_COUNT',   10);
	define('CODE_CHAR_COLORS',   "#880000,#008800,#000088,#888800,#880088,#008888,#000000");
	define('CODE_LINE_COLORS',   "#DD6666,#66DD66,#6666DD,#DDDD66,#DD66DD,#66DDDD,#666666");
	define('CODE_BG_COLOR',      "#FFFFFF");
	define('CODE_ALLOWED_CHARS', "ABCDEFGHJKLMNPQRSTUVWXYZ2345689");
	define('PATH_TTF',           "captcha/fonts");
	
	function create_captcha($data = '', $img_path = '', $img_url = '', $font_path = '')
	{
		$defaults = array('word' => '', 'img_path' => '', 'img_url' => '', 'img_width' => '150', 'img_height' => '30', 'font_path' => '', 'expiration' => 7200);
		foreach ($defaults as $key => $val)
		{
			if ( ! is_array($data))
			{
				if ( ! isset($$key) OR $$key == '')
				{
					$$key = $val;
				}
			}
			else
			{
				$$key = ( ! isset($data[$key])) ? $val : $data[$key];
			}
		}

		if ($img_path == '' OR $img_url == '')
		{
			return FALSE;
		}

		if ( ! @is_dir($img_path))
		{
			return FALSE;
		}

		if ( ! is_writable($img_path))
		{
			return FALSE;
		}

		if ( ! extension_loaded('gd'))
		{
			return FALSE;
		}
		
		// -----------------------------------
		// Remove old images
		// -----------------------------------

		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);

		$current_dir = @opendir($img_path);

		while ($filename = @readdir($current_dir))
		{
			if ($filename != "." and $filename != ".." and $filename != "index.html")
			{
				$name = str_replace(".jpg", "", $filename);

				if (($name + $expiration) < $now)
				{
					@unlink($img_path.$filename);
				}
			}
		}

		@closedir($current_dir);
		
		$line_colors = preg_split("/,\s*?/", CODE_LINE_COLORS);
		$char_colors = preg_split("/,\s*?/", CODE_CHAR_COLORS);
		$fonts = collect_files(PATH_TTF, "ttf");
		
		$img = imagecreatetruecolor(CODE_WIDTH, CODE_HEIGHT);
		imagefilledrectangle($img, 0, 0, CODE_WIDTH - 1, CODE_HEIGHT - 1, gd_color(CODE_BG_COLOR));

		
		// Draw lines

	for ($i = 0; $i < CODE_LINES_COUNT; $i++)
		imageline($img,
        rand(0, CODE_WIDTH - 1),
        rand(0, CODE_HEIGHT - 1),
        rand(0, CODE_WIDTH - 1),
        rand(0, CODE_HEIGHT - 1),
        gd_color($line_colors[rand(0, count($line_colors) - 1)])
    );
		
		// Draw code

	$code = "";
	$y = (CODE_HEIGHT / 2) + (CODE_FONT_SIZE / 2);
	for ($i = 0; $i < CODE_CHARS_COUNT; $i++) {
		$color = gd_color($char_colors[rand(0, count($char_colors) - 1)]);
		$angle = rand(-30, 30);
		$char = substr(CODE_ALLOWED_CHARS, rand(0, strlen(CODE_ALLOWED_CHARS) - 1), 1);
		$font = PATH_TTF . "/" . $fonts[rand(0, count($fonts) - 1)];
		$x = (intval((CODE_WIDTH / CODE_CHARS_COUNT) * $i) + (CODE_FONT_SIZE / 2));
		$code .= $char;
		imagettftext($img, CODE_FONT_SIZE, $angle, $x, $y, $color, $font, $char);
	}
		// -----------------------------------
		//  Generate the image
		// -----------------------------------

		$img_name = $now.'.jpg';

		ImageJPEG($img, $img_path.$img_name);
		$img_width = CODE_WIDTH;
		$img_height = CODE_HEIGHT;

		$img = "<img src=\"$img_url$img_name\" width=\"$img_width\" height=\"$img_height\" style=\"border:1px solid #021a40;\" alt=\" \" />";

		//ImageDestroy($img);

		return array('word' => $code, 'time' => $now, 'image' => $img);
		
	}
	function gd_color($html_color){
    return preg_match('/^#?([\dA-F]{6})$/i', $html_color, $rgb)
      ? hexdec($rgb[1]) : false;
	}
	function collect_files($dir, $ext){
    if (false !== ($dir = opendir($dir))) {
        $files = array();

        while (false !== ($file = readdir($dir)))
            if (preg_match("/\\.$ext\$/i", $file))
                $files[] = $file;

        return $files;

    } else
        return false;
	}
}

// ------------------------------------------------------------------------

/* End of file captcha_helper.php */
/* Location: ./system/heleprs/captcha_helper.php */