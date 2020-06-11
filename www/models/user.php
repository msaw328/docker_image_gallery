<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/db.inc.php');

    // maps to table 'users' in DB

    class User {
        public $id;
        public $name;
        public $pwhash;
        public $email;

        private function __construct($id, $name, $pwhash, $email) {
            $this->id = $id;
            $this->name = $name;
            $this->pwhash = $pwhash;
            $this->email = $email;
        }

        // returns instance of User class, fetches data from DB by id
        static function get($id) {
            $dbh = db_get_conn();

            $query = 'SELECT * FROM users WHERE id = :id';

            try {
                $stmt = $dbh->prepare($query);
                $stmt->execute([':id' => $id]);

                if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    return new User($row['id'], $row['name'], $row['pwhash'], $row['email']);
                } else {
                    return NULL;
                }
            } catch(PDOException $e) {
                return $e;
            }
        }

        // checks whether user with given name OR mail exists
        static function exists($name, $email) {
            $dbh = db_get_conn();

            $query = 'SELECT COUNT(*) as "num" FROM users WHERE name = :name OR email = :email';

            try {
                $stmt = $dbh->prepare($query);
                $stmt->execute([':name' => $name, ':email' => $email]);

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                return intval($row['num']) > 0; // if count > 0 a user exists
            } catch(PDOException $e) {
                return $e;
            }
        }

        // returns instance of User class, fetches data from DB by name
        static function get_by_name($name) {
            $dbh = db_get_conn();

            $query = 'SELECT * FROM users WHERE name = :name';

            try {
                $stmt = $dbh->prepare($query);
                $stmt->execute([':name' => $name]);

                if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    return new User($row['id'], $row['name'], $row['pwhash'], $row['email']);
                } else {
                    return NULL;
                }
            } catch(PDOException $e) {
                return $e;
            }
        }

        // inserts new user into database, returns id of newly created user
        static function insert($name, $pwhash, $email) {
            $dbh = db_get_conn();

            $query = 'INSERT INTO users (name, pwhash, email) VALUES (:name, :pwhash, :email)';
            
            try {
                $stmt = $dbh->prepare($query);

                $stmt->execute([':name' => $name, ':pwhash' => $pwhash, ':email' => $email]);

                return $dbh->lastInsertId('users_id_seq');
            } catch(PDOException $e) {
                return $e;
            }
        }

        // deletes user from database, by id
        static function delete($id) {
            $dbh = db_get_conn();

            $query = 'DELETE FROM users WHERE id = :id';

            try {
                $stmt = $dbh->prepare($query);

                $stmt->execute([':id' => $id]);

                return NULL;
            } catch(PDOException $e) {
                return $e;
            }
        }
    }
?>
