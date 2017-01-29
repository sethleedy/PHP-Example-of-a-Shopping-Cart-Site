<?php # Script 5.4 - index.php

/* 
 *	This is the main page.
 *	This page doesn't do much.
 */

// Require the configuration file before any PHP code:
require_once ('./includes/config.inc.php');

// Include the header file:
include_once ('./includes/header.html');

// Page-specific content goes here:
echo '<h1>[WoW] World of Widgets</h1>
<p>Put introductory information here. Marketing. Whatever. Put introductory information here. Marketing. Whatever. Put introductory information here. Marketing. Whatever. Put introductory information here. Marketing. Whatever. </p>
<p>Put introductory information here. Marketing. Whatever. Put introductory information here. Marketing. Whatever. Put introductory information here. Marketing. Whatever. Put introductory information here. Marketing. Whatever. </p>

<h1>[WoW] World of Widgets</h1>
<p>Put introductory information here. Marketing. Whatever. Put introductory information here. Marketing. Whatever. Put introductory information here. Marketing. Whatever. Put introductory information here. Marketing. Whatever. </p>
<p>Put introductory information here. Marketing. Whatever. Put introductory information here. Marketing. Whatever. Put introductory information here. Marketing. Whatever. Put introductory information here. Marketing. Whatever. </p>';

// Include the footer file to complete the template:
include_once ('./includes/footer.html');

?>
