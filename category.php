<?php # Script 5.5 - category.php

/* 
 *	This page represents a specific category.
 *	This page shows all the widgets classified
 *	under that category.
 *	The page expects to receive a $_GET['cid'] value.
 */

// Require the configuration file before any PHP code:
require_once ('./includes/config.inc.php');

// Check for a category ID in the URL:
$category = NULL;
if (isset($_GET['cid'])) {

	// Typecast it to an integer:
	$cid = (int) $_GET['cid'];
	// An invalid $_GET['cid'] value would
	// be type-casted to 0.
	
	// $cid must have a valid value.
	if ($cid > 0) {
	
		// Get the information from the database
		// for this category:
		
		// Connect up
		$link = $PDOConnection->connectLink();
		try {
			
			$statement = $link->prepare("SELECT category, description FROM categories WHERE category_id=$cid");

			// Get rows from the DB
			$statement->execute();

			// Fetch the information:
			//if ($statement->rowCount() == 1) {
				list($category, $description) = $statement->fetch(PDO::FETCH_NUM);
			//}
			
		} catch (PDOException $e) {
			
			echo 'PDO Connection failed: ' . $e->getMessage() . '. ';
			
		}
	} // End of ($cid > 0) IF.
	
} // End of isset($_GET['cid']) IF.

// Use the category as the page title:
if ($category) {
	$page_title = $category;
}

// Include the header file:
include_once ('./includes/header.html');

if ($category) { // Show the products.

	echo "<h1>$category</h1>\n";

	// Print the category description, if it's not empty.
	if (!empty($description)) {
		echo "<p>$description</p>\n";
	}

	try {
		// Get the widgets in this category:
		$statement = $link->prepare("SELECT gw_id, name, default_price, description FROM general_widgets WHERE category_id=$cid");
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
		$loopResults = $statement->fetchAll(PDO::FETCH_NUM);
		
		// Print each array within the array
		foreach ($loopResults as $tmpLoop) {
			
			// Break out the array values
			list($gw_id, $wname, $wprice, $wdescription) = $tmpLoop;

			// Link to the product.php page:
			echo "<h2><a href=\"product.php?gw_id=$gw_id\">$wname</a></h2><p>$wdescription<br />\$$wprice</p>\n";
			
		}
		
	} else { // No widgets here!
		echo '<p class="error">There are no widgets in this category.</p>';
	}

} else { // Invalid $_GET['cid']!
	echo '<p class="error">This page has been accessed in error.</p>';
}

// Include the footer file to complete the template:
include_once ('./includes/footer.html');

?>
