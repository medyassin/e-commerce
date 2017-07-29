<?php 

	/* ================== Start Front-End Functinos ================*/

	/*
	** Get Categories  Function V1
	** Function to get Categories From Database
	*/

	function getCat () {
		global $con;
		$getCat = $con->prepare("SELECT * FROM cats ORDER BY ID ASC "); // Select all users expect administrators
		$getCat->execute(); // Execute the statement4
		$cats = $getCat->fetchAll(); // Fetch all data
		return $cats;
	}

	/*
	** Get Items Function V1
	** Function to get Categories From Database
	*/

	function getItem ($catid) {
		global $con;
		$getItem = $con->prepare("
									SELECT
										items.*,
										users.Username AS user_name
									FROM 
										items
									JOIN
										users 
									ON
										users.UserID = items.User_ID
									WHERE
										items.Cat_ID = $catid
									ORDER BY Item_ID DESC
									LIMIT 5

			");

		$getItem->execute(); // Execute the statement4
		$items = $getItem->fetchAll(); // Fetch all data
		return $items;
	}	












	/* ================== End Front-End Functinos ================*/

	/* ================== Back-End FuncitionS ==================*/

	/*
	** TITLE FUNCTION V1.0
	** add page title dynamicly
	*/
	function getTitle() {

		global $pageTitle;

		if (isset($pageTitle)) {
			echo $pageTitle;
		} else {
			echo 'Default';
		}
	}

	/*
	** Home Redirect Function V2 
	** V2 : add $url params [it accept 3 params]
	** $theMsg : Echo the  Message [Error, Success, Warning]
	** $s : Number of Seconds before Redirecting
	** $url : redirect target [null:index.php, Custom, 'back']
	*/

	function redirectHome ($theMsg, $url = null, $s = 3) {

		if ($url == null) {

			$url = 'index.php';

			$link = 'home page';

		} elseif ($url == 'back') {

			if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

				$url = $_SERVER['HTTP_REFERER'];

				$link = 'Previous';

			} else {

				$url = 'index.php';
				$link = 'home page';

			}
		}

		$link ='targer page';
		
		echo $theMsg;
		echo "<div class='alert alert-info'>You will be redirected to $link after $s seconds</div>";
		header("refresh: $s; url = $url");

	};

	/*
	** CHECK ITEMS FUNCTION V1.0
	** Function to check Items in Database
	** It Accept two params
	** $select = The Item to Select i.e: user, cat, item
	** $from = The table to Select from i.e: users, item, cat
	** $value = The Value of Select i.e: yassin, box, Electronics
	*/

	function checkItem ($select, $from, $value) {
		global $con;
		$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
		$statement->execute(array($value));
		$count = $statement->rowCount();
		return $count;
	};


	/*
	** COUNT NUMBER OF ITEMS FUNCTION V2
	** Count Number of items rows [Accept 2 params]
	** $Item: The Items to count
	** $table: The table to chose from
	** $cond: WHERE something as condition
	*/

	function countItems ($item, $table, $cond = null) {

		global $con;

		if ($cond == null) {
			$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
		} else {
			$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table WHERE $cond");
		}

		$stmt2->execute();

		return $stmt2->fetchColumn();
	}


	/*
	** GETLATEST ELEMENT FUNCTION V1
	** This function return an arry of elts [users, items, comments] [Accept 4 params]
	** $select : i.e FullName
	*/

	function getLatest ($select, $table, $order, $limit = 5) {
		global $con;
		$stmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit"); // Select all users expect administrators
		$stmt->execute(); // Execute the statement4
		$rows = $stmt->fetchAll(); // Fetch all data
		return $rows;
	}