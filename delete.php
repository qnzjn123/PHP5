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
$sql = "DELETE FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header("Location: index.php");
    exit;
} else {
    $stmt->close();
    $conn->close();
    echo "게시글 삭제에 실패했습니다.";
}
?>
