<?php # Script 5.1 - config.inc.php

/* 
 *	Configuration file does the following things:
 *	- Has site settings in one location.
 *	- Stores URLs and URIs as constants.
 *	- Sets how errors will be handled.
 *	- Establishes a connection to the database.
 */


# ******************** #
# ***** SETTINGS ***** #

// Errors are emailed here.
$contact_email = 'webmaster@sethleedy.name'; 

// Determine whether we're working on a local server
// or on the real server:
// The organization that doles out IP addresses to the world reserves a range of IP addresses for private networks. 
// Private networks can use IP addresses anywhere in the following ranges:
//		192.168.0.0 - 192.168.255.255 (65,536 IP addresses)
//		172.16.0.0 - 172.31.255.255 (1,048,576 IP addresses)
//		10.0.0.0 - 10.255.255.255 (16,777,216 IP addresses)
if (stristr($_SERVER['HTTP_HOST'], 'local') || (substr($_SERVER['HTTP_HOST'], 0, 7) == '192.168') || (substr($_SERVER['HTTP_HOST'], 0, 6) == '172.16') || (substr($_SERVER['HTTP_HOST'], 0, 2) == '10')) {
	$local = TRUE;
} else {
	$local = FALSE;
}


// Determine location of files and the URL of the site:
// Allow for development on different servers.
if ($local) {

	// Always debug when running locally:
	$debug = TRUE;
	
	// Define the constants:
	define ('BASE_URI', '/var/www/html/Ch05/');
	define ('BASE_URL',	'http://localhost/Ch05/');
	
} else {

	define ('BASE_URI', '/2016/phpmysql/week7-8/Ch05/');
	define ('BASE_URL',	'http://schoolstuff.sethleedy.name/2016/phpmysql/week7-8/Ch05/');
	define ('DB_inc', 'mysql.inc.php');
} 
	
/* 
 *	Most important setting...
 *	The $debug variable is used to set error management.
 *	To debug a specific page, do this:

$debug = TRUE;
require_once('./includes/config.inc.php');

 *	on that page.
 *
 *	To debug the entire site, do

$debug = TRUE;

 *	before this next conditional.
 */

// Assume debugging is off. 
if (!isset($debug)) {
	$debug = FALSE;
	//$debug = TRUE;
}

# ***** SETTINGS ***** #
# ******************** #


# **************************** #
# ***** ERROR MANAGEMENT ***** #

// Create the error handler.
function my_error_handler ($e_number, $e_message, $e_file, $e_line, $e_vars) {

	global $debug, $contact_email;
	
	// Build the error message.
	$message = "An error occurred in script '$e_file' on line $e_line: \n<br />$e_message\n<br />";
	
	// Add the date and time.
	$message .= "Date/Time: " . date('n-j-Y H:i:s') . "\n<br />";
	
	// Append $e_vars to the $message.
	$message .= "<pre>" . print_r ($e_vars, 1) . "</pre>\n<br />";
	
	if ($debug) { // Show the error.
	
		echo '<p class="error">' . $message . '</p>';
		
	} else { 
	
		// Log the error:
		error_log ($message, 1, $contact_email); // Send email.
		
		// Only print an error message if the error isn't a notice or strict.
		if ( ($e_number != E_NOTICE) && ($e_number < 2048)) {
			echo '<p class="error">A system error occurred. We apologize for the inconvenience.</p>';
		}
		
	} // End of $debug IF.

} // End of my_error_handler() definition.

// Use my error handler:
set_error_handler ('my_error_handler');

# ***** ERROR MANAGEMENT ***** #
# **************************** #

//// Database

// Connect & open MySQL DB
include_once("mysql.inc.php");


?>
