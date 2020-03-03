<?php


if ($act == 'list') {
	$q = $db->prepare("SELECT * FROM tasks");
	$q->execute();
	$data = $q->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($data);
} elseif (isset($_POST) && $act == 'add') {
	$_POST = json_decode(file_get_contents('php://input'), true);
	$_POST['defination'] = $_POST['defination'] ?? '';
	$q = $db->prepare("INSERT INTO tasks SET title = :title, defination = :defination, due_date = :due_date, due_time = :due_time");
	$r = $q->execute($_POST);
	if ($r) {
		$last_inserted = $db->lastInsertId();
		$q = $db->prepare("SELECT * FROM tasks WHERE id = :id");
		$q->execute(['id' => $last_inserted]);
		$data = $q->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($data);
	} else {
		echo json_encode($r);
	}
} elseif ($act == 'edit' && isset($param)) {
	$_POST = json_decode(file_get_contents('php://input'), true);
	$q = $db->prepare("UPDATE tasks SET title = :title, defination = :defination, due_date = :due_date, due_time = :due_time WHERE id = :id");
	$r = $q->execute(array_merge($_POST, ['id' => $param]));
	$_POST['defination'] = $_POST['defination'] ?? '';
	if ($r) {
		$q = $db->prepare("SELECT * FROM tasks WHERE id = :id");
		$q->execute(['id' => $param]);
		$data = $q->fetch(PDO::FETCH_ASSOC);
		echo json_encode($data);
	} else {
		echo json_encode($r);
	}
} elseif ($act == 'change' && isset($param)) {

	$q = $db->prepare("SELECT * FROM tasks WHERE id = :id");
	$q->execute(['id' => $param]);
	$data = $q->fetch(PDO::FETCH_ASSOC);

	$q = $db->prepare("UPDATE tasks SET is_completed = :is_completed WHERE id = :id");
	$r = $q->execute([
		'is_completed' => $data['is_completed'] == 0 ? 1 : 0,
		'id' => $param
	]);
	echo (int) $data['is_completed'] == 0 ? 1 : 0;
} elseif ($act == 'delete' & isset($param)) {
	$q = $db->prepare("DELETE FROM tasks WHERE id = :id");
	$r = $q->execute([
		'id' => $param
	]);
}
