UPGRADE FROM 1.0.8 to 2.0.0
=======================

# DB update

```mysql
ALTER TABLE `genj_faq_question `
  ADD is_active TINYINT(1) NOT NULL after rank, 
  ADD publish_at DATETIME NOT NULL after is_active,
  ADD expires_at DATETIME DEFAULT NULL after publish_at;
  
UPDATE genj_faq_question SET 
    is_active = 1,
    publish_at = created_at;
```