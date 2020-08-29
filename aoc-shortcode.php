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

add_shortcode( 'run-code', 'aoc_embed' );

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
		
		$before = '<div style="height: 500px; overflow: hidden; width: 500px;"> <iframe id="myframe" scrolling="no" src="';
		$after  = '" style="transform: scale(0.65, 0.65) perspective(1px); zoom : 99%;'. /*https://stackoverflow.com/a/41469542*/
				  'height: 830px; margin-top: -190px;  margin-left: -316px; width: 1135px;"> </iframe> </div>';
	//}

	$array = str_split($content);

	if($atts['lang'] == null || ($atts['lang'] != "c" && $atts['lang'] != "c++" && $atts['lang'] != "java" && $atts['lang'] != "python"))
		return "Error, lang attribute is missing or wrong! it should be [c, c++, java or python].".
			   "\n<br>Proper use: [run-code lang=\"<span style='font-style: italic; font-weight: 100;'>programming-lang</span>\"] <span style='font-style: italic; font-weight: 100;'>some-code</span> [/run-code]";

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

add_shortcode( 'code', 'ace_embed' );

function ace_embed($atts, $content = null){

	if($atts['lang'] == null)
		return "Error, lang attribute is missing!.".
			   "\n<br>Proper use: [code lang=\"<span style='font-style: italic; font-weight: 100;'>programming-lang</span>\"] <span style='font-style: italic; font-weight: 100;'>some-code</span> [/code]";
	
	

	return "<p>UnderConstruction!</p>";
}

$supportedModes = {
    ABAP:        ["abap"],
    ABC:         ["abc"],
    ActionScript:["as"],
    ADA:         ["ada|adb"],
    Alda:        ["alda"],
    Apache_Conf: ["^htaccess|^htgroups|^htpasswd|^conf|htaccess|htgroups|htpasswd"],
    Apex:        ["apex|cls|trigger|tgr"],
    AQL:         ["aql"],
    AsciiDoc:    ["asciidoc|adoc"],
    ASL:         ["dsl|asl"],
    Assembly_x86:["asm|a"],
    AutoHotKey:  ["ahk"],
    BatchFile:   ["bat|cmd"],
    C_Cpp:       ["cpp|c|cc|cxx|h|hh|hpp|ino"],
    C9Search:    ["c9search_results"],
    Cirru:       ["cirru|cr"],
    Clojure:     ["clj|cljs"],
    Cobol:       ["CBL|COB"],
    coffee:      ["coffee|cf|cson|^Cakefile"],
    ColdFusion:  ["cfm"],
    Crystal:     ["cr"],
    CSharp:      ["cs"],
    Csound_Document: ["csd"],
    Csound_Orchestra: ["orc"],
    Csound_Score: ["sco"],
    CSS:         ["css"],
    Curly:       ["curly"],
    D:           ["d|di"],
    Dart:        ["dart"],
    Diff:        ["diff|patch"],
    Dockerfile:  ["^Dockerfile"],
    Dot:         ["dot"],
    Drools:      ["drl"],
    Edifact:     ["edi"],
    Eiffel:      ["e|ge"],
    EJS:         ["ejs"],
    Elixir:      ["ex|exs"],
    Elm:         ["elm"],
    Erlang:      ["erl|hrl"],
    Forth:       ["frt|fs|ldr|fth|4th"],
    Fortran:     ["f|f90"],
    FSharp:      ["fsi|fs|ml|mli|fsx|fsscript"],
    FSL:         ["fsl"],
    FTL:         ["ftl"],
    Gcode:       ["gcode"],
    Gherkin:     ["feature"],
    Gitignore:   ["^.gitignore"],
    Glsl:        ["glsl|frag|vert"],
    Gobstones:   ["gbs"],
    golang:      ["go"],
    GraphQLSchema: ["gql"],
    Groovy:      ["groovy"],
    HAML:        ["haml"],
    Handlebars:  ["hbs|handlebars|tpl|mustache"],
    Haskell:     ["hs"],
    Haskell_Cabal: ["cabal"],
    haXe:        ["hx"],
    Hjson:       ["hjson"],
    HTML:        ["html|htm|xhtml|vue|we|wpy"],
    HTML_Elixir: ["eex|html.eex"],
    HTML_Ruby:   ["erb|rhtml|html.erb"],
    INI:         ["ini|conf|cfg|prefs"],
    Io:          ["io"],
    Jack:        ["jack"],
    Jade:        ["jade|pug"],
    Java:        ["java"],
    JavaScript:  ["js|jsm|jsx"],
    JSON:        ["json"],
    JSON5:       ["json5"],
    JSONiq:      ["jq"],
    JSP:         ["jsp"],
    JSSM:        ["jssm|jssm_state"],
    JSX:         ["jsx"],
    Julia:       ["jl"],
    Kotlin:      ["kt|kts"],
    LaTeX:       ["tex|latex|ltx|bib"],
    LESS:        ["less"],
    Liquid:      ["liquid"],
    Lisp:        ["lisp"],
    LiveScript:  ["ls"],
    LogiQL:      ["logic|lql"],
    LSL:         ["lsl"],
    Lua:         ["lua"],
    LuaPage:     ["lp"],
    Lucene:      ["lucene"],
    Makefile:    ["^Makefile|^GNUmakefile|^makefile|^OCamlMakefile|make"],
    Markdown:    ["md|markdown"],
    Mask:        ["mask"],
    MATLAB:      ["matlab"],
    Maze:        ["mz"],
    MediaWiki:   ["wiki|mediawiki"],
    MEL:         ["mel"],
    MIXAL:       ["mixal"],
    MUSHCode:    ["mc|mush"],
    MySQL:       ["mysql"],
    Nginx:       ["nginx|conf"],
    Nim:         ["nim"],
    Nix:         ["nix"],
    NSIS:        ["nsi|nsh"],
    Nunjucks:    ["nunjucks|nunjs|nj|njk"],
    ObjectiveC:  ["m|mm"],
    OCaml:       ["ml|mli"],
    Pascal:      ["pas|p"],
    Perl:        ["pl|pm"],
    Perl6:       ["p6|pl6|pm6"],
    pgSQL:       ["pgsql"],
    PHP:         ["php|inc|phtml|shtml|php3|php4|php5|phps|phpt|aw|ctp|module"],
    PHP_Laravel_blade: ["blade.php"],
    Pig:         ["pig"],
    Powershell:  ["ps1"],
    Praat:       ["praat|praatscript|psc|proc"],
    Prisma:      ["prisma"],
    Prolog:      ["plg|prolog"],
    Properties:  ["properties"],
    Protobuf:    ["proto"],
    Puppet:      ["epp|pp"],
    Python:      ["py"],
    QML:         ["qml"],
    R:           ["r"],
    Razor:       ["cshtml|asp"],
    RDoc:        ["Rd"],
    Red:         ["red|reds"],
    RHTML:       ["Rhtml"],
    RST:         ["rst"],
    Ruby:        ["rb|ru|gemspec|rake|^Guardfile|^Rakefile|^Gemfile"],
    Rust:        ["rs"],
    SASS:        ["sass"],
    SCAD:        ["scad"],
    Scala:       ["scala|sbt"],
    Scheme:      ["scm|sm|rkt|oak|scheme"],
    SCSS:        ["scss"],
    SH:          ["sh|bash|^.bashrc"],
    SJS:         ["sjs"],
    Slim:        ["slim|skim"],
    Smarty:      ["smarty|tpl"],
    snippets:    ["snippets"],
    Soy_Template:["soy"],
    Space:       ["space"],
    SQL:         ["sql"],
    SQLServer:   ["sqlserver"],
    Stylus:      ["styl|stylus"],
    SVG:         ["svg"],
    Swift:       ["swift"],
    Tcl:         ["tcl"],
    Terraform:   ["tf", "tfvars", "terragrunt"],
    Tex:         ["tex"],
    Text:        ["txt"],
    Textile:     ["textile"],
    Toml:        ["toml"],
    TSX:         ["tsx"],
    Twig:        ["latte|twig|swig"],
    Typescript:  ["ts|typescript|str"],
    Vala:        ["vala"],
    VBScript:    ["vbs|vb"],
    Velocity:    ["vm"],
    Verilog:     ["v|vh|sv|svh"],
    VHDL:        ["vhd|vhdl"],
    Visualforce: ["vfp|component|page"],
    Wollok:      ["wlk|wpgm|wtest"],
    XML:         ["xml|rdf|rss|wsdl|xslt|atom|mathml|mml|xul|xbl|xaml"],
    XQuery:      ["xq"],
    YAML:        ["yaml|yml"],
    Zeek:        ["zeek|bro"],
    Django:      ["html"]
};