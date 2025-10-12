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
$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    $conn->close();
    header("Location: index.php");
    exit;
}

$post = $result->fetch_assoc();
$stmt->close();

// 폼 제출 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $content = $_POST['content'] ?? '';
    
    if (!empty($title) && !empty($author) && !empty($content)) {
        $update_sql = "UPDATE posts SET title = ?, author = ?, content = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssi", $title, $author, $content, $id);
        
        if ($update_stmt->execute()) {
            $update_stmt->close();
            $conn->close();
            header("Location: view.php?id=" . $id);
            exit;
        } else {
            $error = "게시글 수정에 실패했습니다.";
        }
        
        $update_stmt->close();
    } else {
        $error = "모든 항목을 입력해주세요.";
    }
}

$conn->close();
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
