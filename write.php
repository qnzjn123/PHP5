<?php
require_once 'config.php';

// 폼 제출 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $content = $_POST['content'] ?? '';
    
    if (!empty($title) && !empty($author) && !empty($content)) {
        $conn = getDBConnection();
        
        $sql = "INSERT INTO posts (title, author, content) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $title, $author, $content);
        
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: index.php");
            exit;
        } else {
            $error = "게시글 작성에 실패했습니다.";
        }
        
        $stmt->close();
        $conn->close();
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
    <title>글쓰기 - 게시판</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>글쓰기</h1>
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
                <input type="text" id="title" name="title" required value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="author">작성자</label>
                <input type="text" id="author" name="author" required value="<?php echo isset($_POST['author']) ? htmlspecialchars($_POST['author']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="content">내용</label>
                <textarea id="content" name="content" required><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?></textarea>
            </div>

            <div class="button-group">
                <a href="index.php" class="btn">목록</a>
                <button type="submit" class="btn btn-primary">등록</button>
            </div>
        </form>
    </div>
</body>
</html>
