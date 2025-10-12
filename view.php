<?php
require_once 'config.php';

// 게시글 ID 확인
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$conn = getDBConnection();

// 조회수 증가
$update_sql = "UPDATE posts SET views = views + 1 WHERE id = :id";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bindParam(':id', $id, PDO::PARAM_INT);
$update_stmt->execute();

// 게시글 조회
$sql = "SELECT * FROM posts WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - 게시판</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>게시판</h1>
        </div>
    </header>

    <div class="container">
        <div class="post-view">
            <div class="post-header">
                <h2 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h2>
                <div class="post-meta">
                    <span>작성자: <?php echo htmlspecialchars($post['author']); ?></span>
                    <span>조회수: <?php echo $post['views']; ?></span>
                    <span>작성일: <?php echo date('Y-m-d H:i:s', strtotime($post['created_at'])); ?></span>
                </div>
            </div>

            <div class="post-content">
                <?php echo nl2br(htmlspecialchars($post['content'])); ?>
            </div>

            <div class="post-actions">
                <a href="index.php" class="btn">목록</a>
                <a href="edit.php?id=<?php echo $post['id']; ?>" class="btn">수정</a>
                <a href="delete.php?id=<?php echo $post['id']; ?>" class="btn" onclick="return confirm('정말 삭제하시겠습니까?');">삭제</a>
            </div>
        </div>
    </div>
</body>
</html>
