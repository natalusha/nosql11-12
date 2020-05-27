<?php 

	namespace application\core;
	use \PDO;

	class Model extends PDO
    {
        public $pdo;

        public function __construct()
        {
            $dsn = "mysql:host=" . HOST . ";dbname=" . DB . ";charset=" . CHARSET;

            $opt = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo = new PDO($dsn, USER, PASS, $opt);
            $this->pdo = $pdo;
        }

        protected function createRecord($table, $columns = [], $values = [])
        {
            $this->pdo->query("SET TRANSACTION ISOLATION LEVEL READ COMMITTED;");
            $this->pdo->beginTransaction();
            
            $sql = 'INSERT INTO ' . $table . '(' . implode(",", $columns) . ') VALUES  ( "' . implode('","', $values) . '")';

            $query = $this->pdo->prepare($sql);
            $query->execute();
            
            $res = $this->pdo->lastInsertId();
            $this->pdo->commit();
            return $res;
        }

        protected function updateRecord($table, $columns = [], $values = [], $whereConditionName, $condition)
        {
            $queryParametersString = array_map(function ($col, $val) {
                return $col .' = "'. $val . '"';
            }, $columns, $values);

            $sql = 'UPDATE ' . $table . ' SET ' . implode(", ", $queryParametersString) . ' WHERE ' . $whereConditionName . ' = ' . $condition;
            $query = $this->pdo->prepare($sql);
            $query->execute();

            return $this->pdo->lastInsertId();
        }
        protected function getAllByAuthor($id)
        {
            $query = $this->pdo->query('SELECT work_name, cr_year, frst_name, scnd_name FROM works INNER JOIN id_w_id_a ON works.id_works = id_w_id_a.id_w INNER JOIN authors ON authors.id_authors = id_w_id_a.id_a WHERE authors.id_authors = ' . $id);
            $result = $query->fetchAll();

            return $result;
        }

        protected function getAllWithRelations()
        {
            $sql = 'SELECT * FROM works 
            INNER JOIN id_w_id_a ON works.id_works = id_w_id_a.id_w 
            INNER JOIN authors ON authors.id_authors = id_w_id_a.id_a 
            INNER JOIN id_c_id_a ON id_c_id_a.id_a = authors.id_authors
            INNER JOIN countries ON countries.id_countries = id_c_id_a.id_c
            INNER JOIN id_g_id_w ON id_g_id_w.id_w = works.id_works
            INNER JOIN genre ON genre.id_genre = id_g_id_w.id_g';

            $query = $this->pdo->query($sql);
            $result = $query->fetchAll();

            return $result;
        }

        protected function getAllWithRelationsByWork($id)
        {
            $sql = 'SELECT * FROM works 
            INNER JOIN id_w_id_a ON works.id_works = id_w_id_a.id_w 
            INNER JOIN authors ON authors.id_authors = id_w_id_a.id_a 
            INNER JOIN id_c_id_a ON id_c_id_a.id_a = authors.id_authors
            INNER JOIN countries ON countries.id_countries = id_c_id_a.id_c
            INNER JOIN id_g_id_w ON id_g_id_w.id_w = works.id_works
            INNER JOIN genre ON genre.id_genre = id_g_id_w.id_g WHERE works.id_works = '.$id;

            $query = $this->pdo->query($sql);
            $result = $query->fetchAll();

            return $result;
        }

        protected function getAllFromTable($table)
        {
            $query = $this->pdo->query('SELECT * from ' . $table);
            $result = $query->fetchAll();

            return $result;
        }
        // protected function getAllRecords($table, $columns = [], $condition = '')
        // {
        //     if(!empty($condition)) {
        //         $query = $this->pdo->query( 'SELECT '. implode(",", $columns) . ' FROM ' . $table . ' WHERE id_authors=' . $condition );
        //     }
        //     else {
        //         $query = $this->pdo->query( 'SELECT '. implode(",", $columns) . ' FROM ' . $table );
        //     }
        //     $result = $query->fetchAll();
        //     return $result;
        // }

        protected function getAllWhere($table, $condition, $id)
        {
            $query = $this->pdo->query( 'SELECT * FROM ' . $table . ' WHERE ' .$condition. '=' .$id );
            $result = $query->fetchAll();
            return $result;
        }

        protected function getOne($table, $condition, $id)
        {
            $query = $this->pdo->prepare('SELECT * FROM ' . $table . ' WHERE ' .$condition. ' = ' . $id);
            $query->execute();
            $result = $query->fetch();
            return $result;
        }

        protected function deleteRecord($table, $condition, $id)
        {
            $sql = 'DELETE FROM ' . $table . ' WHERE ' . $condition . ' = ' . $id;
            $query = $this->pdo->prepare($sql);
            $query->execute();

            return $this->pdo->lastInsertId();
        }

	}