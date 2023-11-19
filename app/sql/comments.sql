CREATE TABLE `comments` (
  `commenter_name` text NOT NULL,
  `comment` text NOT NULL,
  `article_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
