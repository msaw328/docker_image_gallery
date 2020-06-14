<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/db.inc.php');

    // maps to table 'categories' in DB

    class Category {
        public $id;
        public $owner_id;
        public $name;

        private function __construct($id, $owner_id, $name) {
            $this->id = $id;
            $this->owner_id= $owner_id;
            $this->name = $name;
        }

        static function get($id) {
            $dbh = db_get_conn();

            $query = 'SELECT * FROM categories WHERE id = :id';

            try {
                $stmt = $dbh->prepare($query);

                $stmt->execute([':id' => $id]);

                if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    return new Category($row['id'], $row['owner_id'], $row['name']);
                } else {
                    return NULL;
                }
            } catch(PDOException $e) {
                return $e;
            }

        }

        static function get_owned($user_id) {
            $dbh = db_get_conn();

            $query = 'SELECT * FROM categories WHERE owner_id = :user_id';

            try {
                $stmt = $dbh->prepare($query);

                $stmt->execute([':user_id' => $user_id]);

                $results = array();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $cat = new Category($row['id'], $row['owner_id'], $row['name']);
                    array_push($results, $cat);
                }

                return $results;
            } catch(PDOException $e) {
                return $e;
            }
        }

        static function insert($owner_id, $name) {
            $dbh = db_get_conn();

            $query = 'INSERT INTO categories (owner_id, name) VALUES (:owner_id, :name)';

            try {
                $stmt = $dbh->prepare($query);

                $stmt->execute([':owner_id' => $owner_id, ':name' => $name]);

                return $dbh->lastInsertId('categories_id_seq');
            } catch(PDOException $e) {
                return $e;
            }
        }

        static function delete($id) {
            $dbh = db_get_conn();

            $query = 'DELETE FROM categories WHERE id = :id';

            try {
                $stmt = $dbh->prepare($query);

                $stmt->execute([':id' => $id]);
            } catch(PDOException $e) {
                return $e;
            }
        }
    }
?>
