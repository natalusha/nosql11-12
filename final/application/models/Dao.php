<?php 
	namespace application\models;

    interface Dao
    {
        public function create();
        public function getAll();
        public function getOne();
        public function getAllByKeys();
        public function update();
    }