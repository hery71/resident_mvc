<?php
class TaskController
{
public function addTask()
    {
        $id_inspection = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        //En fonction du type il va charger les options de l inspection
        $typeOptions = Config::inspection()[$type] ?? [];
        $model = new MenageModel();
        $inspectionDetail = $model->getInspectionDetailsById($id_inspection);
        $taskS = $model->getTasksByInspectionId($id_inspection);

        
        require __DIR__ . '/../views/menage/task/addTask.php';
    }   
public function saveTask()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data =[
                 'id_inspection' => $_POST['id_inspection'] ?? '0',
                'aile' => $_POST['aile'] ?? '',
                'room' => $_POST['room'] ?? '',
                'typeInspection' => $_POST['typeInspection'] ?? '',
                'task' => $_POST['task'] ?? '',
                'observation' => $_POST['observation'] ?? '',
                'date' => $_POST['date'] ?? ''
            ];
            $model = new MenageModel();
            $model->saveTask($data);

            header('Location: /task/addTask?id=' . ($_POST['id_inspection'] ?? ''));
            exit;
        }
    }
public function deleteTask()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_task = $_POST['id_task'] ?? '0';
            $id_inspection = $_POST['id_inspection'] ?? '0';

            $model = new MenageModel();
            $model->deleteTask($id_task);

            header('Location: /task/addTask?id=' . $id_inspection);
            exit;
        }
    }
}