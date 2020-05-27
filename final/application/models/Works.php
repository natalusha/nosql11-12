<?php 
	namespace application\models;
    use application\models\Dao;

    class Works implements Dao
    {
        public $worksCollection1;
        public $worksCollection2;
        public $worksCollection3;
        public $table = 'works';

        public function __construct()
        {
            require "application\core\Db.php";

            $this->worksCollection1 = $client[0]->worksCollection1;
            $this->worksCollection2 = $client[1]->worksCollection2;
            $this->worksCollection3 = $client[2]->worksCollection3;
            parent::__construct();
        }

        public function create($workValues, $authorValues, $genreValues, $countryValues, $db, $dbReplica)
        {
            if($db == 'mongo') {
                $data = ['name' => 'Test', 'age' => 12];
                if ($dbReplica == 1) {
                    $this->worksCollection1->insertOne($data);
                }
                if ($dbReplica == 2) {
                    $this->worksCollection2->insertOne($data);
                }
                if ($dbReplica == 3) {
                    $this->worksCollection3->insertOne($data);
                }

                
            }
            else {
                $workKey = $this->createWork($workValues);
                $authorKey = $this->createAuthor($authorValues);
                $genreKey = $this->createGenre($genreValues);
                $countryKey = $this->createCountry($countryValues);

                $this->createWorksAuthorsRelations($workKey, $authorKey);
                $this->createGenreWorkRelations($genreKey, $workKey);
                $this->createCountryAuthorRelations($countryKey, $authorKey);
            }
            
        }

        public function update($db, $dbReplica)
        {
            if($db = 'mongo') {
                $data = ['name' => 'Test', 'age' => 12], ['$set'=> ['name' => 'Updated', 'age' => 13, 'makitra' => 1]]
                if ($dbReplica == 1) {
                    $this->worksCollection1->updateMany($data);
                }
                if ($dbReplica == 2) {
                    $this->worksCollection2->updateMany($data);
                }
                if ($dbReplica == 3) {
                    $this->worksCollection3->updateMany($data);
                }
            }
            else {
                if(!empty($data['workValues'])) {
                    $this->updateWork($data['workValues']['columns'], 
                                      $data['workValues']['values'], 
                                      $data['workValues']['condition']);
                    $workUKey = $data['workValues']['condition'];
                }
            }
        }

        public function updateWork($columns, $values, $condition)
        {
            return $this->updateRecord('works', $columns, $values, 'id_works', $condition);
        }

        public function getOne($db, $dbReplica)
        {
            if($db = 'mongo') {
                if ($dbReplica == 1) {
                    return $this->worksCollection1->findOne(['name' => 'Test', 'age' => 12]);
                }
                if ($dbReplica == 2) {
                    return $this->worksCollection2->findOne(['name' => 'Test', 'age' => 12]);
                }
                if ($dbReplica == 3) {
                    return $this->worksCollection3->findOne(['name' => 'Test', 'age' => 12]);
                }

                $c = $this->worksCollection3->findOne(['name' => 'Test', 'age' => 12]);

                $ops = [
                    [
                        '$project' => [
                            "work" => 1,
                            "tags"   => 1,
                        ] 
                    ],
                    [
                        '$unwind' => '$tags'
                    ],
                    [
                        '$group' => [
                            "_id" => ["tags" => '$tags'],
                            "works" => ['$addToSet' => '$work'],
                        ],
                    ]
                ];

                $result = $c->aggregate($ops);
            }
            else {
                return $this->getOne($this->table, 'id_works', intval($id));
            }
        }

        public function getAllByKeys($db, $dbReplica)
        {
            if($db = 'mongo') {
                if ($dbReplica == 1) {
                    return $this->worksCollection1->find(['name' => 'Test', 'age' => 12]);
                }
                if ($dbReplica == 2) {
                    return $this->worksCollection2->find(['name' => 'Test', 'age' => 12]);
                }
                if ($dbReplica == 3) {
                    return $this->worksCollection3->find(['name' => 'Test', 'age' => 12]);
                }
                
                $c = $this->worksCollection3->find(['name' => 'Test', 'age' => 12]);

                $ops = [
                    [
                        '$project' => [
                            "work" => 1,
                            "tags"   => 1,
                        ] 
                    ],
                    [
                        '$unwind' => '$tags'
                    ],
                    [
                        '$group' => [
                            "_id" => ["tags" => '$tags'],
                            "works" => ['$addToSet' => '$work'],
                        ],
                    ]
                ];

                $result = $c->aggregate($ops);
            }
            else {
                return $this->getAllByTag(['name' => 'Test', 'age' => 12]);
            }
        }

        public function getAll($db, $dbReplica)
        {
            if($db = 'mongo') {
                if ($dbReplica == 1) {
                    return $this->worksCollection1->find();
                }
                if ($dbReplica == 2) {
                    return $this->worksCollection2->find();
                }
                if ($dbReplica == 3) {
                    return $this->worksCollection3->find();
                }
            }
            else {
                return $this->getAllWithRelations();
            }
        }

        private function createWork($values)
        {
            $columns = ['work_name', 'cr_year'];
            return $this->createRecord('works', $columns, $values);
        }

        private function createAuthor($values)
        {
            $columns = ['frst_name', 'scnd_name', 'pen_name', 'birth', 'death'];
            return $this->createRecord('authors', $columns, $values);
        }

        private function createGenre($values) 
        {
            $columns = ['genre_name'];
            return $this->createRecord('genre', $columns, $values);
        }

        private function createCountry($values)
        {
            $columns = ['country_name', 'city_name'];
            return $this->createRecord('countries', $columns, $values);
        }

        private function createWorksAuthorsRelations($workKey, $authorKey)
        {
            $columns = ['id_w', 'id_a'];
            $this->createRecord('id_w_id_a', $columns, [$workKey, $authorKey]);
        }

        private function createGenreWorkRelations($genreKey, $workKey)
        {
            $columns = ['id_g', 'id_w'];
            $this->createRecord('id_g_id_w', $columns, [$genreKey, $workKey]);
        }

        private function createCountryAuthorRelations($countryKey, $authorKey)
        {
            $columns = ['id_c', 'id_a'];
            $this->createRecord('id_c_id_a', $columns, [$countryKey, $authorKey]);
        }

    }
