<?php

	class DBObject {
		
		// Set all databsae details for connecting
		public $dbDetails = array(
			"servername" => "localhost",
			"username" => "dev",
			"password" => "sql_dev_pass",
			"dbname" => "ecommerce"
//			,
//			'tablename' => "zip_codes"
		);
		
		// Connect to database and return a connection variable
		function connectLink() {

			$dbDetails=$this->dbDetails;
			
			try {
				$link = new PDO("mysql:host=" . $dbDetails['servername'] . ";dbname=" . $dbDetails['dbname'], $dbDetails['username'], $dbDetails['password']);
				
			} catch (PDOException $e) {

				echo 'PDO Connection failed: ' . $e->getMessage().'. ';
				$this->closeLink();

				exit();
			}

			return $link;
		}
		
		// Close DB
		function closeLink() {
			return $link = null;
		}
		
	}
	
	// Create the global database object for use throughout the scripts.
	$PDOConnection = new DBObject;


	// Get all the categories and link them to category.php.
	function display_category_list($PDOConnection) {
	
		// Define vars:
		$strReturnHTML="";
		
		// Connect up
		$link = $PDOConnection->connectLink();

		// Execute the query
		try {
			$statement = $link->prepare("SELECT category_id, category FROM categories ORDER BY category");
			// Get rows from the DB
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			

			foreach ($result as $row) {
				//var_dump($row);
				$strReturnHTML .= "<li><a href='category.php?cid=" . $row["category_id"] . "'>" . $row["category"] . "</a></li>";
			}

			// Close Connection
			$statement=null;
			$PDOConnection->closeLink();
			
			return $strReturnHTML;

		} catch (PDOException $e) {

			echo 'PDO Connection failed: ' . $e->getMessage() . '. ';
			
		}

	}

			
	function display_number_cart_items()
{
	if ($_SERVER["PHP_SELF"] != "CART FILE" ) {
		$itemCount = 0;
		
		// Check if the variable exists first
		if (isset($_SESSION["cart"])) {
			foreach($_SESSION["cart"] as  $order) {
				$itemCount += 1;
			}
			
			return "<a href='cart.php'>You have " . $itemCount . " items in your cart.</a>";
		} else {
			return "<a href='cart.php'>You have 0 items in your cart.</a>";
		}
		
	}
}

?>
