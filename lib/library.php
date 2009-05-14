<?php

// OB_START
ob_start();

/*
**  S I T E   V A R I A B L E S
*/
// This is were you put the name of your website
$SITE_NAME = 'Acero-Framework';

// These variables point to the base URL and relative address
// of your website
$addr = address();
$rel_addr = relative_address();

// You can add more things here

/*
**   S E S S I O N S
* 		you can add lotsa separate session stuff here
*/
include $rel_addr.'/sessions/session.php';

/*
** I N C L U D E   F I L E S
* 		this is where it all comes together
*		feel free to add your own things
*/
	// Database Connection
	include $rel_addr.'/lib/mysql_connect.php';
	
	// Header File
	include $rel_addr.'/lib/header.php';
	
	// Scripts File
	include $rel_addr.'/lib/scripts.php';
	
	// Navigation File
	include $rel_addr.'/lib/navigation.php';
	
	// Footer File
	include $rel_addr.'/lib/footer.php';

/*
**   M Y S Q L 
*/
	// returns a database connection if you've successfully connected to one
	function db_connect ($db_url, $db, $user, $pw){
		if($dbc = @mysql_connect($db_url,$user,$pw)){
			if (!@mysql_select_db ($db)){
				return die('<p>Could not select the database because: <B>' . mysql_error() . '');
			}else{
				return $dbc;
			}
		}else{
				return die('<P>Could not connect to the MYSQL because: <B>' . mysql_error() . '');
		}
	}

/*
**   P H P
*/
	// returns the base URL of your website
	// i.e., if this function is used in http://www.madeup.com/what.php
	//	 it will return http://www.madeup.com
	function address (){
		return 'http://'.$_SERVER['SERVER_NAME'].'';
	}
	
	// returns the physical location of your website
	// just for easy access really
	function relative_address(){
		// Or whatever your server points to
		return '/var/www';
	}

	// You can use this with cheap CSS hacks
	// i.e., to change the css file if its IE
	function is_ie (){
		//Not Internet Explorer
		if(stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE') === FALSE) {
			return false;
		//Is Internet Explorer
		}else{
			return true;
		}
	}
	
	//Retrieves page's name
	function this_page(){
		return $_SERVER['PHP_SELF'];
	}
	
	// Goto if object is clicked
	function click_get($var_name, $var){
		return 'OnClick="parent.location=\''.this_page().'?'.$var_name.'='.$var.'\'"';
	}
	
	// Refresh if item is selected
	function click_refresh($page = 'default'){
		if($page == 'default'){
			return 'OnClick="parent.location=\''.this_page().'\'"';
		}else {
			return 'OnClick="parent.location=\''.$page.'\'"';
		}
	}
	
	// Submit form on click
	function click_submit(){
		return 'OnClick="this.form.submit()"';
	}

	// Refresh a page
	function refresh ($page = 'none', $dbpage = 'none',$seconds = 0){
		$address = address();
		switch(TRUE){
			// refresh page to http://www.example.com/blog.php?page=2
			case ($page != 'none' && $dbpage != 'none'):
				return header('refresh: '.$seconds.'; url='.$address.$page.'?page='.$dbpage.'');
				break;
				
			// refresh page to http://www.example.com/blog.php
			case ($page != 'none'):
				return header('refresh: '.$seconds.'; url='.$address.$page.'');
				break;
				
			// refreshes to the same page and sets the variable page to something
			case($dbpage != 'none'):
				return header('refresh: '.$seconds.'; url='.$address.this_page().'?page='.$dbpage.'');
				break;
				
			// refreshes to the same page
			case($page == 'none'):
				return header('refresh: '.$seconds.'; url='.$address.this_page().'');
				break;
		}
	}

	function title ($title){
		if(!empty($title)){
			return '<TITLE>'.$title.' - '.$GLOBALS['SITE_NAME'].'</TITLE>';
		}else{
			return '<TITLE>'.$GLOBALS['SITE_NAME'].'</TITLE>';
		}
	}

	function style ($style){
		$reset 	 = '/style/reset.css';
		$style 	 = '/style/style.css';

		return '
			<link type="text/css" rel="stylesheet" href="'.address().$reset.'">
			<link type="text/css" rel="stylesheet" href="'.address().$style.'">
		';
	}

	function navigation ($nav){
		if(empty($nav)){
			return '
				
				';
		}else{
			return $nav;
		}
	}
	function headCheck ($header){
		if(empty($header)){
			return ''.$GLOBALS['SITE_NAME'].'';
		}else{
			return $header;
		}
	}
	
/*
**    P A G E 
**      C R E A T I O N
*/
	function head ($title, $style, $scripts){
		
		$return ='
		<html>
		<head>

		'.title($title).'

		'.style($style).'
				
		'.$scripts.'
		
		</head>
		';
		
		echo $return;
	}

function body ($header,$subtitle=' ',$content,$navigation){
		$return .= '
		<body>
		
			<div id="header">
				<h1 onclick="goHome()" id="title">'.headCheck($header).'</h1>
			</div>
			
			<div id="nav">'.navigation($navigation).'</div>
	
			<div id="content">
				<h1>'.$subtitle.'</h1>
				'.$content.'
			</div>
			';
		echo $return;
	}

	function foot ($footer = 'All Rights Reserved',$dbc){
		$date = date("m/d/Y");

			$return = '
			<div id="footer">
			'.$footer.'
			</div>
			
			</body>
	
		
			</html>
			';
		
		echo $return;
		
		ob_end_flush();
		if($dbc){
			mysql_close($dbc);
		}
	}
	
?>
