use btlBLog;

create table users (
    id_email varchar(50) NOT NULL PRIMARY KEY,
    gmail varchar(200) NOT NULL,
    username varchar(200) NOT NULL,
    avatar varchar(200) NOT NULL,
    fullname text DEFAULT NULL,
    follow_number int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table posts (
    post_id int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_email varchar(50) NOT NULL,
    subject longtext NOT NULL,
    content longtext NOT NULL,
    format_subject longtext NOT NULL, 
    format_content longtext NOT NULL,
    like_number int(10) DEFAULT 0,
    comment_number int(10) DEFAULT 0,
    img longtext DEFAULT NULL,
    created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_email) REFERENCES users(id_email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table comments (
    comment_id int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_email varchar(50) NOT NULL,
    post_id int(10) unsigned NOT NULL,
    comment_content longtext NOT NULL,
    created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_email) REFERENCES users(id_email),
    FOREIGN KEY (post_id) REFERENCES posts(post_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;