<?php # Script 5.6 - product.php

/* 
 *	This is the product page.
 *	This page shows all the specific 
 *	products available for a given $_GET['gw_id'].
 *	Links allow customers to add items to their cart.
 */

// Require the configuration file before any PHP code:
require_once ('./includes/config.inc.php');

// Check for a general product ID in the URL.
$name = NULL;
if (isset($_GET['gw_id'])) {

	// Typecast it to an integer:
	$gw_id = (int) $_GET['gw_id'];
	
	// $gw_id must have a valid value.
	if ($gw_id > 0) {
	
		// Get the information from the database
		// for this product:
		
		// Connect up
		$link = $PDOConnection->connectLink();
		try {
			
			$statement = $link->prepare("SELECT name, default_price, description FROM general_widgets WHERE gw_id=$gw_id");

			// Get rows from the DB
			$statement->execute();

			// Fetch the information:
			//if ($statement->rowCount() == 1) {
				list($name, $price, $description) = $statement->fetch(PDO::FETCH_NUM);
			//}
			
		} catch (PDOException $e) {
			
			echo 'PDO Connection failed: ' . $e->getMessage() . '. ';
			
		}
		
	
	} // End of ($gw_id > 0) IF.
	
} // End of isset($_GET['gw_id']) IF.

// Use the name as the page title:
if ($name) {
	$page_title = $name;
}

// Include the header file:
include_once ('./includes/header.html');

if ($name) { // Show the specific products.

	echo "<h1>$name</h1>\n";
	
	// Print the product description, if it's not empty.
	if (!empty($description)) {
		echo "<p>$description</p>\n";
	}
	
	try {
		// Get the widgets in this category:
		$statement = $link->prepare("SELECT sw_id, color, size, price, in_stock FROM specific_widgets LEFT JOIN colors using (color_id) LEFT JOIN sizes USING (size_id) WHERE gw_id=$gw_id ORDER BY size, color");
		// Get rows from the DB
		$statement->execute();
	} catch (PDOException $e) {
			
		echo 'PDO Connection failed: ' . $e->getMessage() . '. ';
			
	}
	
	// Alternative ?
	// http://php.net/manual/en/pdostatement.rowcount.php
	// If the last SQL statement executed by the associated PDOStatement was a SELECT statement, some databases may return the number of rows returned by that statement. However, this behaviour is not guaranteed for all databases and should not be relied on for portable applications.
	if ($statement->rowCount() > 0) {
		
		// Find all
		$loopResults = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		// Print each:
		echo '<h3>Available Sizes and Colors</h3>';
	
		foreach ($loopResults as $row) {
		
			// Determine the price:
			$price = (empty($row['price'])) ? $price : $row['price'];
		
			// Print most of the information:
			echo "<p>Size: {$row['size']}<br />Color: {$row['color']}<br /> Price: \$$price<br />In Stock?: {$row['in_stock']}";
			
			// Print cart link:
			if ($row['in_stock'] == 'Y') {
				echo "<br /> <a href=\"cart.php?sw_id={$row['sw_id']}&do=add\">Add to Cart</a>";
			}
			
			echo '</p>';
			
		} // End of WHILE loop.
		
	} else { // No specific widgets here!
		echo '<p class="error">There are none of these widgets available for purchase at this time.</p>';
	}

} else { // Invalid $_GET['gw_id']!
	echo '<p class="error">This page has been accessed in error.</p>';
}

// Include the footer file to complete the template:
include_once ('./includes/footer.html');

?>
