<?php
// SQLite 데이터베이스 설정
define('DB_FILE', __DIR__ . '/database.db');

// 데이터베이스 연결 (SQLite)
function getDBConnection() {
    try {
        $conn = new PDO('sqlite:' . DB_FILE);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        die("데이터베이스 연결 실패: " . $e->getMessage());
    }
}

// 데이터베이스 및 테이블 생성
function initDatabase() {
    try {
        $conn = getDBConnection();
        
        // 테이블 생성
        $sql = "CREATE TABLE IF NOT EXISTS posts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            author TEXT NOT NULL,
            content TEXT NOT NULL,
            views INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        
        $conn->exec($sql);
    } catch(PDOException $e) {
        die("테이블 생성 실패: " . $e->getMessage());
    }
}

// 초기화
initDatabase();
?>
