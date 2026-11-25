# ER図

書籍管理アプリケーションの主要テーブルとリレーションを示します。Laravel標準の補助テーブル（パスワードリセット、ジョブ、APIトークンなど）は含みません。

```mermaid
erDiagram
    USERS ||--o{ BOOKS : "登録する"
    USERS ||--o{ REVIEWS : "投稿する"
    BOOKS ||--o{ REVIEWS : "レビューされる"
    USERS ||--o{ FAVORITES : "お気に入りにする"
    BOOKS ||--o{ FAVORITES : "お気に入り登録される"
    BOOKS ||--o{ BOOK_GENRE : "ジャンルを持つ"
    GENRES ||--o{ BOOK_GENRE : "書籍に付与される"
    USERS ||--o{ REVIEW_LIKES : "いいねする"
    REVIEWS ||--o{ REVIEW_LIKES : "いいねされる"

    USERS {
        BIGINT id PK
        VARCHAR name
        VARCHAR email UK
        TIMESTAMP email_verified_at "NULL"
        VARCHAR password
        VARCHAR remember_token "NULL"
        TIMESTAMP created_at "NULL"
        TIMESTAMP updated_at "NULL"
    }

    BOOKS {
        BIGINT id PK
        BIGINT user_id FK
        VARCHAR title
        VARCHAR author
        VARCHAR isbn UK
        DATE published_date
        TEXT description
        VARCHAR image_url
        TIMESTAMP created_at "NULL"
        TIMESTAMP updated_at "NULL"
    }

    GENRES {
        BIGINT id PK
        VARCHAR name UK
        TIMESTAMP created_at "NULL"
        TIMESTAMP updated_at "NULL"
    }

    BOOK_GENRE {
        BIGINT id PK
        BIGINT book_id FK
        BIGINT genre_id FK
        TIMESTAMP created_at "NULL"
        TIMESTAMP updated_at "NULL"
    }

    REVIEWS {
        BIGINT id PK
        BIGINT user_id FK
        BIGINT book_id FK
        TINYINT rating
        TEXT comment
        TIMESTAMP created_at "NULL"
        TIMESTAMP updated_at "NULL"
    }

    FAVORITES {
        BIGINT id PK
        BIGINT user_id FK
        BIGINT book_id FK
        TIMESTAMP created_at "NULL"
        TIMESTAMP updated_at "NULL"
    }

    REVIEW_LIKES {
        BIGINT id PK
        BIGINT user_id FK
        BIGINT review_id FK
        TIMESTAMP created_at "NULL"
        TIMESTAMP updated_at "NULL"
    }
```

## 制約と補足

- `books.user_id` は書籍を登録したユーザーを参照します。ユーザー削除時は、そのユーザーの書籍も削除されます。
- `reviews` はユーザーと書籍の中間にあるレビューです。ユーザーまたは書籍の削除時にレビューも削除されます。
- `favorites` はユーザーと書籍の多対多関係を表し、`(user_id, book_id)` の組み合わせは一意です。
- `book_genre` は書籍とジャンルの多対多関係を表し、`(book_id, genre_id)` の組み合わせは一意です。
- `review_likes` はユーザーとレビューの多対多関係を表し、`(user_id, review_id)` の組み合わせは一意です。
- `users.email`、`books.isbn`、`genres.name` は一意です。
- `reviews.rating` は符号なしの1バイト整数です。`books.isbn` は13文字です。
- 外部キーの削除時動作は、各マイグレーションで指定されたカスケード削除です。
