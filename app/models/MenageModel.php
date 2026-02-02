<?php
require_once dirname(__DIR__, 2) . '/app/config/db.php';
class MenageModel
{
    private $pdo;
    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }
    public function inspectionList($annee)
    {
        $sqlt = "SELECT * FROM inspection_list 
                WHERE year(`date`) = :annee
                AND enabled = 1
                ORDER BY `date` ASC;";

        $stmt = $this->pdo->prepare($sqlt);
        $stmt->execute([
            'annee' => $annee
        ]);
        return $stmt->fetchall();
    }
    public function createInspection($data)
    {
        $inspectionData =[
            'date'          => $data['date'],
            'type'          => $data['type_inspection'],
            'nom'           => $data['nom'],
            'staff'         => $data['id_staff'],
            'observation'  => $data['observation']
        ];
        $sqlx = "INSERT INTO inspection_list 
                (date, type, nom, staff, observation, enabled) 
                VALUES 
                (:date, :type, :nom, :staff, :observation, 1);";
        $stmt = $this->pdo->prepare($sqlx);
        return $stmt->execute($inspectionData);
    }   
    public function deleteInspection($id_inspection)
    {
        $sqlx = "DELETE FROM inspection_list 
                 WHERE id = :id_inspection;";
        $stmt = $this->pdo->prepare($sqlx);
        return $stmt->execute([
            'id_inspection' => $id_inspection
        ]);
    }
    public function getInspectionDetailsById($id_inspection)
    {
        $sqlt = "SELECT * FROM inspection_list 
                 WHERE id = :id_inspection
                 AND enabled = 1
                 LIMIT 1;";
        $stmt = $this->pdo->prepare($sqlt);
        $stmt->execute([
            'id_inspection' => $id_inspection
        ]);
        return $stmt->fetch();
    }
    public function getTasksByInspectionId($id_inspection)
    {
        $sqlt = "SELECT * FROM inspection_task 
                 WHERE inspection_id = :id_inspection
                 AND enabled = 1
                 ORDER BY aile ASC, room ASC, task ASC;";
        $stmt = $this->pdo->prepare($sqlt);
        $stmt->execute([
            'id_inspection' => $id_inspection
        ]);
        return $stmt->fetchall();
    }   
    public function saveTask($data)
    {
        $taskData =[
            'inspection_id'   => $data['id_inspection'],
            'aile'            => $data['aile'],
            'room'            => $data['room'],
            'task'            => $data['task'],
            'observation'     => $data['observation']
        ];
        $sqlx = "INSERT INTO inspection_task 
                (inspection_id, aile, room, task, observation, enabled, value) 
                VALUES 
                (:inspection_id, :aile, :room, :task, :observation, 1, 1);";
        $stmt = $this->pdo->prepare($sqlx);
        return $stmt->execute($taskData);
    }
    public function deleteTask($id_task)
    {
        $sqlx = "UPDATE inspection_task 
        SET enabled= 0
        WHERE id = :id_task;";
        $stmt = $this->pdo->prepare($sqlx);
        return $stmt->execute([
            'id_task' => $id_task
        ]);
    }
}