Databases
=========

In database names, "pre" means "prefix" and should be changed in use to something more descriptive.

pre_users
---------
id_user             INT, primary key
id_group            INT, key
user_invited_by     INT, key
user_username       VARCHAR(32), key
user_hash           TEXT
user_email          VARCHAR(128)
user_time_reg       DATETIME
user_time_act       DATETIME, key
user_avatar         VARCHAR(32)
user_ip             VARCHAR(40)
user_seen_blog      TINYINT // Have they read the latest blog post?
user_updated_pass   TINYINT // Have they updated their password to the new system?
user_banned         TINYINT // Is the user banned?
user_ban_lifted     DATETIME // Ban lift time

pre_groups
----------
id_group            INT, primary key
group_name          VARCHAR(32)
group_colour        VARCHAR(6)
group_req_files     INT // Required files to get promoted to this rank. -1 for non-file amount dependent groups.
group_default       TINYINT // Is this the default group?
group_is_mod        TINYINT
group_is_admin      TINYINT
group_hidden        TINYINT

pre_files
---------
id_file             INT, primary key
id_user             INT, key
file_name           VARCHAR(64)
file_size           INT
file_time           DATETIME // Upload time
file_type           VARCHAR(64) // File MIME type (previously "file" or "image")
file_ip             VARCHAR(40)
file_downloads      INT
file_hidden         TINYINT
file_uploader       VARCHAR(32) // If the user from id_user is not found, show this name

pre_referrers
-------------
id_referrer         INT, primary key
id_file             INT, key
referrer_url        VARCHAR(256)
referrer_time       DATETIME

pre_extensions
--------------
id_extension        INT, primary key
extension_ext       VARCHAR(16), key
extension_mime      VARCHAR(64), key
extension_type      TINYINT // 0 => file/default, 1 => image

pre_blog
--------
id_post             INT, primary key
id_user             INT, key
post_title          VARCHAR(64)
post_content        TEXT
post_time           DATETIME
post_username       VARCHAR(32) // If the user from id_user is not found, show this name

pre_invites
-----------
id_invite           INT, primary key
id_user             INT, key
invite_text         VARCHAR(64)
invite_used         TINYINT

pre_comments
------------
id_comment          INT, primary key
id_user             INT, key
comment_type        TINYINT // 0 => file, 1 => blog, 2 => profile
comment_text        TEXT
comment_time        DATETIME

pre_messages
------------
id_message          INT, primary key
id_from             INT, key
id_to               INT, key
message_title       VARCHAR(64)
message_text        TEXT
message_viewed      TINYINT // Has the recipient read the message?
message_del_from    TINYINT // Has the sender deleted the message from their outbox?
message_del_to      TINYINT // Has the recipient deleted the message from their inbox?