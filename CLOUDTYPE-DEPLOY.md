# Cloudtype 배포 가이드

## 배포 방법

1. [Cloudtype](https://cloudtype.io/) 접속 및 로그인
2. **새 프로젝트 만들기** 클릭
3. **GitHub 연동** 선택
4. `PHP5` 저장소 선택
5. 배포 설정:
   - **런타임**: PHP 7.4
   - **포트**: 8080
   - **시작 명령어**: `php -S 0.0.0.0:$PORT`

## 환경 변수 설정

Cloudtype 대시보드에서 다음 환경 변수를 설정하세요:

```
DB_HOST=your-mysql-host
DB_USER=your-db-user
DB_PASS=your-db-password
DB_NAME=board_db
```

## MySQL 데이터베이스

Cloudtype에서 MySQL 애드온을 추가하거나 외부 MySQL 서버를 사용하세요.

## 참고사항

- 데이터베이스는 처음 실행 시 자동으로 생성됩니다
- MySQL 서버가 실행 중이어야 합니다
- PHP 7.4 이상 필요
