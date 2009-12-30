<?php
/*  Copyright 2009  Franz Fuchsbauer  (email : franz@fuchsbauer.at)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/*
Plugin Name: Force Login Except Special IP Range
Plugin URI: http://wordpress.org/extend/plugins/force-login-except-special-ip-range/
Description: Forces all anonymous users to login except the user connects from special IPv4 ranges or a specific IPv4 address. 
 This plugin was written to use wordpress in an intranet/internet environment. Users who are connecting from the intranet
 should see the blog without beeing forced to login. But users connection form the internet must log in to see the blog.
Version: 0.2
Author: Franz Fuchsbauer <franz@fuchsbauer.at>
Author URI: 
*/


class ForceLoginExceptIPRange {

	/*
	 * Constructor - add action hook
	 */
	function ForceLoginExceptIPRange() {
		add_action( 'init', array(&$this, 'checkAccess') );
	}

	function checkAccess() {
		$allowed_ip_ranges=array();
		require_once("allowed_ip_ranges.php");
		if(!is_user_logged_in()) {			
			if(!$this->ignore_page()) { // ignore at least wp-login.php
				// check the ip ranges
				foreach($allowed_ip_ranges as $range) {
					$ip=split(",", $range);
					//echo "check ".trim($ip[0]).",".trim($ip[1])."<br>";
					if($this->in_ip_range(trim($ip[0]), trim($ip[1]))) {
						// allow user to see the page without beeing logged in
						return;
					}
				}
				$this->redirect_to_login();
			}
	       
		}
	}

	/**
	 * checks if actual called page ($_SERVER['PHP_SELF']) should be ignored or not
	 * At least wp-login.php must be ignored, otherwise you run into an endless redirect loop
	 * @return: true: ignore this page, false: do not ignore
	 *	
	*/
	function ignore_page() {
		$ignore_pages=array();
		require_once("ignore_pages.php");
		foreach($ignore_pages as $page) {
			if(substr(strrev($_SERVER['PHP_SELF']),0,strlen($page)) == strrev($page)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * redirects to the login page an appends the REQUEST URI to the url
	**/
	function redirect_to_login() {
		$redirect_to = $_SERVER['REQUEST_URI'];
		$url=get_option('home'); // look for full url
		if(substr(strrev($url),0,1)!='/') {
			// append / to url if it does not end with
			$url.='/';
		}
		$url.='wp-login.php?redirect_to=' . $redirect_to;
		header( 'Location: '.$url );
		exit;
	}
	/**
	* found in a comment from mhakopian at
	* http://www.php.net/manual/en/function.ip2long.php
	* Usage:
	* echo in_ip_range('192.168.0.0','192.168.1.254'); 
	**/
	function in_ip_range($ip_one, $ip_two=false){

	     if($ip_two===false || $ip_two==""){
		if($ip_one==$_SERVER['REMOTE_ADDR']){
		    $ip=true;
		}else{
		    $ip=false;
		}
	    }else{
		if(ip2long($ip_one)<=ip2long($_SERVER['REMOTE_ADDR']) && ip2long($ip_two)>=ip2long($_SERVER['REMOTE_ADDR'])){
		    $ip=true;
		}else{
		    $ip=false;
		}
	    }
	    return $ip;
	}
	
}

new ForceLoginExceptIPRange();

?>
