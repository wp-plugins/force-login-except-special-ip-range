=== Force Login Except Special IP Range ===
Contributors: ff
Donate link: 
Tags: force user login, password, intranet, ip range
Requires at least: 2.9
Tested up to: 2.9
Stable tag: 0.1

Forces all anonymous users to login except the user connects from special ip ranges or a specific IP4 address. 

== Description ==
Forces all anonymous users to login except the user connects from special IPv4 ranges or a specific IPv4 address. 
This plugin was written to use wordpress in an intranet/internet environment. Users who are connecting from the intranet
should see the blog without beeing forced to login. But users connection form the internet must log in to see the blog.
Attention: Works only with IPv4! No IPv6 support!

== Installation ==

1. Upload `force_login_except_ip_range.php` and `allowed_ip_ranges.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Edit `allowed_ip_ranges.php` to add ip ranges to allow access without forcing the user to login.

== Frequently Asked Questions ==

= How do I add an ip range to the allowed ranges? =
Edit `allowed_ip_ranges.php` and add a new line:
 $allowed_ip_ranges[]="STARTIP, STOP_IP";
exmple:
$allowed_ip_ranges[]="192.168.100.0, 192.168.100.255";

= How do I add only one sepecific IP address? =
Edit `allowed_ip_ranges.php` and add a new line:
 $allowed_ip_ranges[]="IP_ADDRESS";
exmple:
$allowed_ip_ranges[]="192.168.100.44";

== Screenshots ==

No screenshot.

== Changelog ==

0.1 initial version

== Upgrade Notice ==

