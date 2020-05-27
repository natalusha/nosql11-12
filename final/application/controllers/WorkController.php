<?php

namespace application\controllers;
use application\core\Controller;
use application\models\Works;

class WorkController extends Controller
{
    public $works;

    public function __construct($route, array $url_params = [], array $post_vars = [])
    {
        parent::__construct($route, $url_params, $post_vars);

        $this->works = new Works;
    }

    public function index()
    {
        $allWorksWithRelations = $this->works->getAll($db = $_GET['selectDB'], $selectReplica = $_GET['selectReplica']);

        $this->view->render('Works',['allInfo' => $allWorksWithRelations]);
    }

    public function insertWork()
    {
        $this->works->create(
            [$_POST['workName'], $_POST['workCreationYear']],
            [$_POST['firstName'], $_POST['secondName'], $_POST['penName'], $_POST['birthDate'], $_POST['deathDate']],
            [$_POST['genre']],
            [$_POST['countryName'], $_POST['cityName']], $db = $_GET['selectDB'], $selectReplica = $_GET['selectReplica']);

        header('location: /');
    }

    public function showUpdate()
    {   
        if (isset($_GET['workId'])) {
            $this->view->render('Update work', ['worksInfo' => $this->works->getOneWork($_GET['workId'], $db = $_GET['selectDB'], $selectReplica = $_GET['selectReplica'])]);
        }
    }

    public function updateWork()
    {
        $this->works->update(
            ['workValues' => [
                    'columns' => ['work_name', 'cr_year'],
                    'values' => [$_POST['workName'], $_POST['workCreationYear']],
                    'condition' => $_POST['workId']
                ],
            ],
            $db = $_GET['selectDB'], $selectReplica = $_GET['selectReplica']
        );
        header('location: /');
    }

    public function deleteWork()
    {
        $this->works->deleteWork($_GET['workToDelete'], $db = $_GET['selectDB'], $selectReplica = $_GET['selectReplica']);
        header('location: /');
    }

    public function showSelect()
    {
        $authors = $this->works->getAllAuthors();
        $this->view->render('Show select', ['authors' => $authors], $db = $_GET['selectDB'], $selectReplica = $_GET['selectReplica']);
    }

    public function selectBookByAuthor()
    {
        $result = $this->works->getWorksByAuthor($_GET['authorId'], $db = $_GET['selectDB'], $selectReplica = $_GET['selectReplica']);

        $this->view->render('Result selection', ['result' => $result]);
    }

    public function showInsertManyWorks()
    {
        $this->view->render('select many works');
    }

    public function insertManyWorks()
    {
        $quantityOfRequests = $_POST['quantityOfRequests'];
        $starttime = microtime(true);

        for ($i = 0; $i < $quantityOfRequests; $i++) {
            $this->works->create(["Kobzar", 1992],
                                 ["Mark", "Sevchenlo", "Kobzar", "2019-12-06", "2019-12-26"],
                                 ["poem"],
                                 ["Sweden", "Stokgolm"], $db = $_GET['selectDB'], $selectReplica = $_GET['selectReplica']);      
        }

        $endtime = microtime(true);
        $duration = $endtime - $starttime; //calculates total time taken

        dump('time of make ' .$quantityOfRequests. ' queries = '. $duration);
    }
}