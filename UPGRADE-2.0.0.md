UPGRADE FROM 1.0.8 to 2.0.0
=======================

# DB update

```mysql
ALTER TABLE `genj_faq_question`
    ADD is_active TINYINT(1) NOT NULL after rank, 
    ADD publish_at DATETIME NOT NULL after is_active,
    ADD expires_at DATETIME DEFAULT NULL after publish_at;
  
UPDATE `genj_faq_question` SET 
    is_active = 1,
    publish_at = created_at;
    
CREATE TABLE `genj_faq_search` (
    id INT AUTO_INCREMENT NOT NULL, 
    headline VARCHAR(255) NOT NULL, 
    search_count INT NOT NULL, 
    created_at DATETIME NOT NULL, 
    updated_at DATETIME NOT NULL, 
    slug VARCHAR(100) NOT NULL, 
    INDEX search_count_idx (search_count), 
    PRIMARY KEY(id)) 
    DEFAULT CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci 
    ENGINE = InnoDB;
```