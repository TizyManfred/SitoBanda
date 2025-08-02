## Database Schema

Key tables include:

## sections
Stores instrument sections (e.g., Woodwinds, Brass, Percussion) in the band.

+---------------+-----------------+------+-----+---------+----------------+
| Field         | Type            | Null | Key | Default | Extra          |
+---------------+-----------------+------+-----+---------+----------------+
| id            | bigint unsigned | NO   | PRI | NULL    | auto_increment |
| name          | varchar(255)    | NO   | UNI | NULL    |                |
| icon_class    | varchar(255)    | YES  |     | NULL    |                |
| image_path    | varchar(255)    | YES  |     | NULL    |                |
| display_order | int             | NO   |     | 0       |                |
| created_at    | timestamp       | YES  |     | NULL    |                |
| updated_at    | timestamp       | YES  |     | NULL    |                |
| deleted_at    | timestamp       | YES  |     | NULL    |                |
+---------------+-----------------+------+-----+---------+----------------+

### Indexes
+----------+------------+----------------------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
| Table    | Non_unique | Key_name             | Seq_in_index | Column_name | Collation | Cardinality | Sub_part | Packed | Null | Index_type | Comment | Index_comment | Visible | Expression |
+----------+------------+----------------------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
| sections |          0 | PRIMARY              |            1 | id          | A         |           3 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
| sections |          0 | sections_name_unique |            1 | name        | A         |           3 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
+----------+------------+----------------------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+

## section_images
Stores multiple images associated with each section.

+---------------+-----------------+------+-----+---------+----------------+
| Field         | Type            | Null | Key | Default | Extra          |
+---------------+-----------------+------+-----+---------+----------------+
| id            | bigint unsigned | NO   | PRI | NULL    | auto_increment |
| section_id    | bigint unsigned | NO   | MUL | NULL    |                |
| image_path    | varchar(255)    | NO   |     | NULL    |                |
| caption       | varchar(255)    | YES  |     | NULL    |                |
| display_order | int             | NO   |     | 0       |                |
| created_at    | timestamp       | YES  |     | NULL    |                |
| updated_at    | timestamp       | YES  |     | NULL    |                |
+---------------+-----------------+------+-----+---------+----------------+

### Indexes
+----------------+------------+-----------------------------------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
| Table          | Non_unique | Key_name                          | Seq_in_index | Column_name | Collation | Cardinality | Sub_part | Packed | Null | Index_type | Comment | Index_comment | Visible | Expression |
+----------------+------------+-----------------------------------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
| section_images |          0 | PRIMARY                           |            1 | id          | A         |           3 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
| section_images |          1 | section_images_section_id_foreign |            1 | section_id  | A         |           2 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
+----------------+------------+-----------------------------------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+

## members
Stores information about band members.

+------------+-----------------+------+-----+---------+----------------+
| Field      | Type            | Null | Key | Default | Extra          |
+------------+-----------------+------+-----+---------+----------------+
| id         | bigint unsigned | NO   | PRI | NULL    | auto_increment |
| first_name | varchar(255)    | NO   | MUL | NULL    |                |
| last_name  | varchar(255)    | NO   |     | NULL    |                |
| section_id | bigint unsigned | NO   | MUL | NULL    |                |
| created_at | timestamp       | YES  |     | NULL    |                |
| updated_at | timestamp       | YES  |     | NULL    |                |
| deleted_at | timestamp       | YES  |     | NULL    |                |
+------------+-----------------+------+-----+---------+----------------+

### Indexes
+---------+------------+-------------------------------------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
| Table   | Non_unique | Key_name                            | Seq_in_index | Column_name | Collation | Cardinality | Sub_part | Packed | Null | Index_type | Comment | Index_comment | Visible | Expression |
+---------+------------+-------------------------------------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
| members |          0 | PRIMARY                             |            1 | id          | A         |          11 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
| members |          0 | members_first_name_last_name_unique |            1 | first_name  | A         |          10 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
| members |          0 | members_first_name_last_name_unique |            2 | last_name   | A         |          11 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
| members |          1 | members_section_id_foreign          |            1 | section_id  | A         |           3 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
+---------+------------+-------------------------------------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+

## gallery_albums
Stores photo albums for the gallery.

+--------------+-------------------+------+-----+---------+----------------+
| Field        | Type              | Null | Key | Default | Extra          |
+--------------+-------------------+------+-----+---------+----------------+
| id           | bigint unsigned   | NO   | PRI | NULL    | auto_increment |
| slug         | json              | YES  |     | NULL    |                |
| year         | smallint unsigned | NO   |     | NULL    |                |
| start_date   | date              | YES  |     | NULL    |                |
| end_date     | date              | YES  |     | NULL    |                |
| is_published | tinyint(1)        | NO   |     | 0       |                |
| view_count   | int unsigned      | NO   |     | 0       |                |
| created_at   | timestamp         | YES  |     | NULL    |                |
| updated_at   | timestamp         | YES  |     | NULL    |                |
| deleted_at   | timestamp         | YES  |     | NULL    |                |
| description  | json              | YES  |     | NULL    |                |
| title        | json              | YES  |     | NULL    |                |
+--------------+-------------------+------+-----+---------+----------------+

### Indexes
+----------------+------------+----------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
| Table          | Non_unique | Key_name | Seq_in_index | Column_name | Collation | Cardinality | Sub_part | Packed | Null | Index_type | Comment | Index_comment | Visible | Expression |
+----------------+------------+----------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
| gallery_albums |          0 | PRIMARY  |            1 | id          | A         |           3 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
+----------------+------------+----------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+

## gallery_items
Stores images and their metadata for the gallery.

+--------------+-----------------+------+-----+---------+----------------+
| Field        | Type            | Null | Key | Default | Extra          |
+--------------+-----------------+------+-----+---------+----------------+
| id           | bigint unsigned | NO   | PRI | NULL    | auto_increment |
| album_id     | bigint unsigned | NO   | MUL | NULL    |                |
| image_path   | varchar(255)    | NO   |     | NULL    |                |
| order_column | int             | NO   |     | 0       |                |
| is_featured  | tinyint(1)      | NO   |     | 0       |                |
| taken_at     | datetime        | YES  |     | NULL    |                |
| created_at   | timestamp       | YES  |     | NULL    |                |
| updated_at   | timestamp       | YES  |     | NULL    |                |
| deleted_at   | timestamp       | YES  |     | NULL    |                |
| sort_order   | int unsigned    | NO   |     | 0       |                |
| caption      | json            | YES  |     | NULL    |                |
+--------------+-----------------+------+-----+---------+----------------+

### Indexes
+---------------+------------+--------------------------------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
| Table         | Non_unique | Key_name                       | Seq_in_index | Column_name | Collation | Cardinality | Sub_part | Packed | Null | Index_type | Comment | Index_comment | Visible | Expression |
+---------------+------------+--------------------------------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
| gallery_items |          0 | PRIMARY                        |            1 | id          | A         |          28 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
| gallery_items |          1 | gallery_items_album_id_foreign |            1 | album_id    | A         |           3 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
+---------------+------------+--------------------------------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+

## events
Stores information about band events and performances.

+-------------------+-----------------+------+-----+---------+----------------+
| Field             | Type            | Null | Key | Default | Extra          |
+-------------------+-----------------+------+-----+---------+----------------+
| id                | bigint unsigned | NO   | PRI | NULL    | auto_increment |
| title             | json            | YES  |     | NULL    |                |
| slug              | json            | YES  |     | NULL    |                |
| description       | json            | YES  |     | NULL    |                |
| short_description | json            | YES  |     | NULL    |                |
| location          | varchar(255)    | NO   |     | NULL    |                |
| address           | text            | YES  |     | NULL    |                |
| latitude          | decimal(10,7)   | YES  |     | NULL    |                |
| longitude         | decimal(10,7)   | YES  |     | NULL    |                |
| start_datetime    | datetime        | NO   | MUL | NULL    |                |
| end_datetime      | datetime        | YES  |     | NULL    |                |
| gallery_id        | bigint unsigned | YES  | MUL | NULL    |                |
| image_path        | varchar(255)    | YES  |     | NULL    |                |
| is_featured       | tinyint(1)      | NO   |     | 0       |                |
| is_public         | tinyint(1)      | NO   | MUL | 1       |                |
| created_at        | timestamp       | YES  |     | NULL    |                |
| updated_at        | timestamp       | YES  |     | NULL    |                |
| deleted_at        | timestamp       | YES  |     | NULL    |                |
+-------------------+-----------------+------+-----+---------+----------------+

### Indexes
+--------+------------+-----------------------------+--------------+----------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
| Table  | Non_unique | Key_name                    | Seq_in_index | Column_name    | Collation | Cardinality | Sub_part | Packed | Null | Index_type | Comment | Index_comment | Visible | Expression |
+--------+------------+-----------------------------+--------------+----------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
| events |          0 | PRIMARY                     |            1 | id             | A         |           1 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
| events |          1 | events_start_datetime_index |            1 | start_datetime | A         |           1 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
| events |          1 | events_is_public_index      |            1 | is_public      | A         |           1 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
| events |          1 | events_gallery_id_foreign   |            1 | gallery_id     | A         |           1 |     NULL |   NULL | YES  | BTREE      |         |               | YES     | NULL       |
+--------+------------+-----------------------------+--------------+----------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+

## repertoire_pieces
Stores information about the repertoire pieces of the band.

+-----------------------+-----------------+------+-----+---------+----------------+
| Field                 | Type            | Null | Key | Default | Extra          |
+-----------------------+-----------------+------+-----+---------+----------------+
| id                    | bigint unsigned | NO   | PRI | NULL    | auto_increment |
| repertoire_program_id | bigint unsigned | NO   | MUL | NULL    |                |
| title                 | varchar(255)    | NO   |     | NULL    |                |
| composer              | varchar(255)    | YES  |     | NULL    |                |
| arranger              | varchar(255)    | YES  |     | NULL    |                |
| genre                 | varchar(255)    | YES  |     | NULL    |                |
| duration              | varchar(255)    | YES  |     | NULL    |                |
| description           | text            | YES  |     | NULL    |                |
| display_order         | int             | NO   |     | 0       |                |
| created_at            | timestamp       | YES  |     | NULL    |                |
| updated_at            | timestamp       | YES  |     | NULL    |                |
+-----------------------+-----------------+------+-----+---------+----------------+

### Indexes
+-------------------+------------+-------------------------------------------------+--------------+-----------------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+      
| Table             | Non_unique | Key_name                                        | Seq_in_index | Column_name           | Collation | Cardinality | Sub_part | Packed | Null | Index_type | Comment | Index_comment | Visible | Expression |      
+-------------------+------------+-------------------------------------------------+--------------+-----------------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+      
| repertoire_pieces |          0 | PRIMARY                                         |            1 | id                    | A         |           0 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |      
| repertoire_pieces |          1 | repertoire_pieces_repertoire_program_id_foreign |            1 | repertoire_program_id | A         |           0 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |      
+-------------------+------------+-------------------------------------------------+--------------+-----------------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+

## repertoire_programs
Stores information about the repertoire programs of the band.

+---------------+-----------------+------+-----+---------+----------------+
| Field         | Type            | Null | Key | Default | Extra          |
+---------------+-----------------+------+-----+---------+----------------+
| id            | bigint unsigned | NO   | PRI | NULL    | auto_increment |
| name          | varchar(255)    | NO   |     | NULL    |                |
| year          | int             | NO   |     | NULL    |                |
| display_order | int             | NO   |     | 0       |                |
| is_published  | tinyint(1)      | NO   |     | 1       |                |
| created_at    | timestamp       | YES  |     | NULL    |                |
| updated_at    | timestamp       | YES  |     | NULL    |                |
+---------------+-----------------+------+-----+---------+----------------+

### Indexes
+---------------------+------------+----------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
| Table               | Non_unique | Key_name | Seq_in_index | Column_name | Collation | Cardinality | Sub_part | Packed | Null | Index_type | Comment | Index_comment | Visible | Expression |
+---------------------+------------+----------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
| repertoire_programs |          0 | PRIMARY  |            1 | id          | A         |           0 |     NULL |   NULL |      | BTREE      |         |               | YES     | NULL       |
+---------------------+------------+----------+--------------+-------------+-----------+-------------+----------+--------+------+------------+---------+---------------+---------+------------+
