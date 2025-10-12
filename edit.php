<?php
require_once 'config.php';

// 게시글 ID 확인
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$conn = getDBConnection();

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

// 폼 제출 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $content = $_POST['content'] ?? '';
    
    if (!empty($title) && !empty($author) && !empty($content)) {
        $update_sql = "UPDATE posts SET title = :title, author = :author, content = :content WHERE id = :id";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bindParam(':title', $title);
        $update_stmt->bindParam(':author', $author);
        $update_stmt->bindParam(':content', $content);
        $update_stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($update_stmt->execute()) {
            header("Location: view.php?id=" . $id);
            exit;
        } else {
            $error = "게시글 수정에 실패했습니다.";
        }
    } else {
        $error = "모든 항목을 입력해주세요.";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>글 수정 - 게시판</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>글 수정</h1>
        </div>
    </header>

    <div class="container">
        <?php if (isset($error)): ?>
            <p style="color: #d32f2f; margin-bottom: 20px; padding: 12px; background-color: #ffebee; border: 1px solid #ef9a9a; border-radius: 4px;">
                <?php echo htmlspecialchars($error); ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="" class="post-form">
            <div class="form-group">
                <label for="title">제목</label>
                <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($post['title']); ?>">
            </div>

            <div class="form-group">
                <label for="author">작성자</label>
                <input type="text" id="author" name="author" required value="<?php echo htmlspecialchars($post['author']); ?>">
            </div>

            <div class="form-group">
                <label for="content">내용</label>
                <textarea id="content" name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>

            <div class="button-group">
                <a href="view.php?id=<?php echo $id; ?>" class="btn">취소</a>
                <button type="submit" class="btn btn-primary">수정</button>
            </div>
        </form>
    </div>
</body>
</html>
