<?php

/**
 * @package AOCOnlineCompiler
 */
/*
 Plugin Name: AOC Shortcode
 Plugin URI: https://github.com/EngAhmedWaleed/AOC-Shortcode
 Description: A Plugin for the AOC online compiler that compiles and runs Java, C++, C, Python code.
 Version: 1.0.0
 Author: Ahmed Waleed
 Author URI: https://ahmedwaleed.csed22.com/ 
 License: CC BY-NC-ND 4.0 or later
 Test Domain: 
 */

/*
 You are free to:
 Share — copy and redistribute the material in any medium or format
 The licensor cannot revoke these freedoms as long as you follow the license terms.
 
 Under the following terms:
 Attribution — You must give appropriate credit, provide a link to the license, and indicate if changes were made. You may do so in any reasonable manner, but not in any way that suggests the licensor endorses you or your use.
 NonCommercial — You may not use the material for commercial purposes.
 NoDerivatives — If you remix, transform, or build upon the material, you may not distribute the modified material.
 No additional restrictions — You may not apply legal terms or technological measures that legally restrict others from doing anything the license permits.

 Notices:
 You do not have to comply with the license for elements of the material in the public domain or where your use is permitted by an applicable exception or limitation.
 No warranties are given. The license may not give you all of the permissions necessary for your intended use. For example, other rights such as publicity, privacy, or moral rights may limit how you use the material.
*/

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

add_shortcode( 'code', 'aoc_embed' );

function aoc_embed($atts, $content = null){

	//$before = '<div style="overflow: hidden; width: 1100px;"> <iframe id="myframe" scrolling="no" src="';
	//$after  = '" style="height: 820px; margin-top: -65px;  margin-left: -174px; width: 1135px;"> </iframe> </div>';

	//if($atts['size'] == "forum"){
		$content = str_replace("&#8216;","'",$content);
		$content = str_replace("&#8217;","'",$content);
		$content = str_replace("&#8220;",'"',$content);
		$content = str_replace("&#8221;",'"',$content);

		/**
		 * //Debug
		 * $js_code = 'console.log(' . json_encode($content, JSON_HEX_TAG). ');';
		 * $js_code = '<script>' . $js_code . '</script>';
		 * echo $js_code;
		 */
		
		$before = '<div style="text-align: right; overflow: hidden; width: 500px;"> <iframe id="myframe" scrolling="no" src="';
		$after  = '" style="transform: scale(0.65, 0.65) perspective(1px); zoom : 99%;'. /*https://stackoverflow.com/a/41469542*/
				  'height: 830px; margin-top: -190px;  margin-left: -316px; width: 1135px;"> </iframe> </div>';
	//}

	$array = str_split($content);

	if($atts['lang'] == null || ($atts['lang'] != "c" && $atts['lang'] != "cpp" && $atts['lang'] != "java" && $atts['lang'] != "python"))
		return "Error, lang attribute is missing or wrong! it should be [c, cpp, java or python].".
			   "\n<br>Proper use: [code lang=\"<span style='font-style: italic; font-weight: 100;'>programming-lang</span>\"] <span style='font-style: italic; font-weight: 100;'>some-code</span> [/code]";

	$lang = "?lang=". $atts['lang']. "&code=";

	$code = $lang. "";

	foreach ($array as $char) {
		if(ord($char) == 10)
			$char = "\0";

		$encoded = dechex(ord($char));

		if(ord($char) < 16)
			$code.= ("%0". $encoded);
		else
			$code.= ("%". $encoded);
	}

	$link = "https://aoc.csed22.com/";

	$iframe = $before. $link. $code. "&light". $after;
	return $iframe;

}