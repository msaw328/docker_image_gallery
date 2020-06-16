<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/db.inc.php');

    // maps to table 'images' in DB

    class Image {
        public $id;
        public $author_id;
        public $cat_id;
        public $title;
        public $descr;
        public $created_at;
        public $mime;
        public $contents;
        public $thumb;

        private function __construct($id, $author_id, $cat_id, $title, $descr, $created_at, $mime, $contents, $thumb) {
            $this->id = $id;
            $this->author_id = $author_id;
            $this->cat_id = $cat_id;
            $this->title = $title;
            $this->descr = $descr;
            $this->created_at = $created_at;
            $this->mime = $mime;
            $this->contents = $contents;
            $this->thumb = $thumb;
        }

        // inserts a new image into the database
        static function insert($author_id, $title, $descr, $mime, $contents, $thumb) {
            $dbh = db_get_conn();

            $contents = bin2hex($contents);
            $thumb = bin2hex($thumb);

            $query = 'INSERT INTO images ('.
                            'author_id, title, descr, created_at, mime, contents, thumb'.
                        ') VALUES ('.
                            ':author_id, :title, :descr, CURRENT_TIMESTAMP(0), :mime, :contents, :thumb'.
                        ')';

            try {
                $stmt = $dbh->prepare($query);
                $stmt->execute([
                    ':author_id' => $author_id,
                    ':title' => $title,
                    ':descr' => $descr,
                    ':mime' => $mime,
                    ':contents' => $contents,
                    ':thumb' => $thumb
                    ]);
                
                return $dbh->lastInsertId('images_id_seq');
            } catch(PDOException $e) {
                return $e;
            }
        }

        // returns a single image by id
        static function get_by_id($id) {
            $dbh = db_get_conn();

            $query = 'SELECT * FROM images WHERE id = :id';

            try {
                $stmt = $dbh->prepare($query);

                $stmt->execute([':id' => $id]);

                if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $actual_contents = hex2bin(fgets($row['contents']));
                    $actual_thumb = hex2bin(fgets($row['thumb']));

                    return new Image(
                        $row['id'], 
                        $row['author_id'],
                        $row['cat_id'],
                        $row['title'], 
                        $row['descr'],
                        $row['created_at'],
                        $row['mime'],
                        $actual_contents,
                        $actual_thumb
                    );
                } else {
                    return NULL;
                }            
            } catch(PDOEXception $e) {
                return $e;
            }
        }

        // return just metadata
        static function get_metadata_by_id($id) {
            $dbh = db_get_conn();

            $query = 'SELECT id, author_id, cat_id, title, descr, created_at FROM images WHERE id = :id';
            
            try {
                $stmt = $dbh->prepare($query);

                $stmt->execute([':id' => $id]);

                if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    return new Image(
                        $row['id'], 
                        $row['author_id'], 
                        $row['cat_id'], 
                        $row['title'], 
                        $row['descr'],
                        $row['created_at'],
                        NULL,
                        NULL,
                        NULL
                    );
                } else {
                    return NULL;
                }            
            } catch(PDOEXception $e) {
                return $e;
            }
        }

        // returns ids of all images a user is allowed to see
        // right now its all images, but if 'private' images are
        // introduced it has to take this setting into account
        static function get_allowed_ids($user_id) {
            $dbh = db_get_conn();

            $query = 'SELECT id FROM images';

            try {
                $stmt = $dbh->prepare($query);

                $stmt->execute();

                $results = array();

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    array_push($results, $row['id']);
                }

                return $results;
            } catch(PDOException $e) {
                return $e;
            }
        }

        static function update_metadata($id, $title, $descr, $cat_id) {
            $dbh = db_get_conn();

            $query = 'UPDATE images SET title = :title, descr = :descr, cat_id = :cat_id WHERE id = :id';

            try {
                $stmt = $dbh->prepare($query);

                $stmt->execute([
                    ':id' => $id,
                    ':title' => $title,
                    ':descr' => $descr,
                    ':cat_id' => $cat_id
                ]);

                return true;
            } catch(PDOException $e) {
                return $e;
            }
        }
    }
?>
