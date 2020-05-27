
# NOSQL 11-12 ПЗ

    public  function  getOne($db, $dbReplica)

	{

	if($db = 'mongo') {

	if ($dbReplica == 1) {

	return  $this->worksCollection1->findOne(['name' => 'Test', 'age' => 12]);

	}

	if ($dbReplica == 2) {

	return  $this->worksCollection2->findOne(['name' => 'Test', 'age' => 12]);

	}

	if ($dbReplica == 3) {

	return  $this->worksCollection3->findOne(['name' => 'Test', 'age' => 12]);

	}

	  

	$c = $this->worksCollection3->findOne(['name' => 'Test', 'age' => 12]);

	  

	$ops = [

	[

	'$project' => [

	"work" => 1,

	"tags" => 1,

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

	return  $this->getOne($this->table, 'id_works', intval($id));

	}

	}

	  

	public  function  getAllByKeys($db, $dbReplica)

	{

	if($db = 'mongo') {

	if ($dbReplica == 1) {

	return  $this->worksCollection1->find(['name' => 'Test', 'age' => 12]);

	}

	if ($dbReplica == 2) {

	return  $this->worksCollection2->find(['name' => 'Test', 'age' => 12]);

	}

	if ($dbReplica == 3) {

	return  $this->worksCollection3->find(['name' => 'Test', 'age' => 12]);

	}

	$c = $this->worksCollection3->find(['name' => 'Test', 'age' => 12]);

	  

	$ops = [

	[

	'$project' => [

	"work" => 1,

	"tags" => 1,

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

	return  $this->getAllByTag(['name' => 'Test', 'age' => 12]);

	}

	}
