<?php
require_once 'config.php';

// 게시글 ID 확인
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$conn = getDBConnection();

// 게시글 삭제
$sql = "DELETE FROM posts WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    header("Location: index.php");
    exit;
} else {
    echo "게시글 삭제에 실패했습니다.";
}
?>
