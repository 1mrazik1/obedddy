<?php
$mysqli = new mysqli("localhost", "root", "", "obedy");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: ({$mysqli->connect_errno}) {$mysqli->connect_error}";
}

function db_end() {
	global $mysqli;
	$mysqli->close();
}

function query($sql) {
	global $mysqli;
	$results = $mysqli->query($sql);
	if (!$results) die("Chyba pri práci s databázou: " . $mysqli->error);
	return $results;
}

function selectUser($userId) {
	$results = query("SELECT * FROM users WHERE id=" . ((int) $userId) . ' LIMIT 1');
	return $results->fetch_assoc();
}

function selectUserByUsername($username) {
	global $mysqli;
	$results = query("SELECT * FROM users WHERE username='" . $mysqli->real_escape_string($username) . "' LIMIT 1");
	if (!$results) return false;
	return $results->fetch_assoc();
}

function selectUserBalance($userId) {
	$results = query("SELECT SUM(SUM) as balance FROM transactions WHERE userId=" . ((int) $userId) . " AND status <> " . STATUS_CANCELED);
	return round($results->fetch_assoc()['balance'], 2);
}

function selectActiveFoods() {
	$results = query("SELECT * FROM foods WHERE foods.date >= CURDATE() ORDER BY date ASC");
	return $results->fetch_all(MYSQLI_ASSOC);
}

function selectTransactions($userId, $page = 0) {
	$results = query("SELECT transactions.id, transactions.sum, transactions.date as orderDate, transactions.status, foods.description, foods.date FROM transactions
		LEFT OUTER JOIN foods ON foods.id = transactions.foodId
		WHERE userId=" . ((int) $userId) . "
		ORDER BY orderDate DESC
		LIMIT 10 OFFSET " . ((int) $page) * 10);
	return $results->fetch_all(MYSQLI_ASSOC);
}

function selectOrders($userId) {
	$sql = "SELECT transactions.id, transactions.sum, transactions.date as orderDate, foods.description, foods.date FROM transactions
		LEFT JOIN foods ON foods.id = transactions.foodId
		WHERE userId=" . ((int) $userId) . " AND status = " . STATUS_OPEN . " AND foods.date >= CURDATE()
		ORDER BY orderDate ASC";
	$results = query($sql);
	return $results->fetch_all(MYSQLI_ASSOC);
}

function orderFood($userId, $foodId) {
	global $currentBalance;
	if ($currentBalance <= FOOD_PRICE) return false;
	return query(sprintf("INSERT INTO transactions (sum, foodId, userId, status) VALUES ('%f', %d, %d, %d)", -FOOD_PRICE, $foodId, $userId, STATUS_OPEN));
}

function cancelOrder($userId, $orderId) {
	return query("UPDATE transactions SET status=" . STATUS_CANCELED . " WHERE userId=" . ((int) $userId) . " AND id=" . ((int) $orderId) . " AND status=" . STATUS_OPEN);
}