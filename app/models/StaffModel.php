<?php
require_once dirname(__DIR__, 2) . '/app/config/db.php';
class StaffModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $GLOBALS['pdo'];
    }
    public function getAllStaffs()
    {
        $sql = "SELECT * FROM staff_tbl where enabled=1 ORDER BY nom, prenom ";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }   
    public function getStaffById($id)
    {
        $sql = "SELECT * FROM staff_tbl WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    public function disableStaff($id)
    {
        $sql = "UPDATE staff_tbl SET enabled = 0 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
    public function updateStaff($data)
    {
        $sql = "UPDATE staff_tbl SET 
                nom = :nom,
                prenom = :prenom,
                middle_name = :middle_name,
                gender = :gender,
                dob = :dob,
                status = :status,
                departement = :departement,
                service = :service,
                poste = :poste,
                tel1 = :tel1,
                tel2 = :tel2,
                adresse_l1 = :adresse_l1,
                adresse_l2 = :adresse_l2,
                code_postal = :code_postal,
                ville = :ville
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'middle_name' => $data['middle_name'],
            'gender' => $data['gender'],
            'dob' => $data['dob'],
            'status' => $data['status'],
            'departement' => $data['departement'],
            'service' => $data['service'],
            'poste' => $data['poste'],
            'tel1' => $data['tel1'],
            'tel2' => $data['tel2'],
            'adresse_l1' => $data['adresse_l1'],
            'adresse_l2' => $data['adresse_l2'],
            'code_postal' => $data['code_postal'],
            'ville' => $data['ville'],
            'id' => $data['id']
        ]);
        return $stmt->rowCount() > 0;
    }
    public function createStaff($data)
    {
        $sql = "INSERT INTO staff_tbl 
                (nom, prenom, middle_name, gender, dob, status, departement, service, poste, tel1, tel2, adresse_l1, adresse_l2, code_postal, ville,enabled)
                VALUES
                (:nom, :prenom, :middle_name, :gender, :dob, :status, :departement, :service, :poste, :tel1, :tel2, :adresse_l1, :adresse_l2, :code_postal, :ville, :enabled)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'middle_name' => $data['middle_name'],
            'gender' => $data['gender'],
            'dob' => $data['dob'],          
            'status' => $data['status'],
            'departement' => $data['departement'],  
            'service' => $data['service'],
            'poste' => $data['poste'],
            'tel1' => $data['tel1'],
            'tel2' => $data['tel2'],
            'adresse_l1' => $data['adresse_l1'],
            'adresse_l2' => $data['adresse_l2'],
            'code_postal' => $data['code_postal'],
            'ville' => $data['ville'],
            'enabled' => 1
        ]);
        return $this->pdo->lastInsertId();          
    }
    public function getOffDays($IdStaff, $startDate)
	{
		$sql = "SELECT id,Date, off, hour, observation
		        FROM off_table
		        WHERE IdStaff = ?
		        AND Date BETWEEN ? AND DATE_ADD(?, INTERVAL 13 DAY)
		        AND enabled = 1";

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([$IdStaff, $startDate, $startDate]);

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$data = [];

		foreach ($rows as $r) {
			$data[$r['Date']] = [
				'id'          => $r['id'],
				'off'         => $r['off'],
				'hour'        => $r['hour'],
				'observation' => $r['observation']
			];
		}

		return $data;
	}
    public function getSumOffByStaff($IdStaff, $startDate)
    {
        $sql = "SELECT off, COUNT(*) AS c
                FROM off_table
                WHERE IdStaff = ?
                AND Date BETWEEN ? AND DATE_ADD(?, INTERVAL 13 DAY)
                AND enabled = 1
                GROUP BY off";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$IdStaff, $startDate, $startDate]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [];

        foreach ($rows as $r) {
            $data[$r['off']] = $r['c'];
        }

        return $data;
    }
    public function getSummaryByStaff($startDate)
    {
        $sql = "SELECT s.id, s.service, s.departement, s.Nom,s.Prenom, o.off, COUNT(*) AS c
                FROM off_table o
                JOIN staff_tbl s ON s.Id = o.IdStaff
                WHERE o.Date BETWEEN ? AND DATE_ADD(?, INTERVAL 13 DAY)
                AND o.enabled = 1
                GROUP BY s.id, s.service, s.departement, s.Nom, s.Prenom, o.off
                ORDER BY s.service, s.departement, s.Nom, s.Prenom";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$startDate, $startDate]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [];

        foreach ($rows as $r) {

            $service     = $r['service'];
            $departement = $r['departement'];
            $name        = $r['id'].'#'.$r['Prenom'].' '.$r['Nom'];
            $off         = $r['off'];

            if (!isset($data[$service][$departement][$name][$off])) {
                $data[$service][$departement][$name][$off] = 0;
            }

            $data[$service][$departement][$name][$off] += $r['c'];
        }

        return $data;
    }

	public function getSummaryByService($startDate)
	{
		$sql = "SELECT s.service, o.off,
		        COUNT(*) AS c,
		        SUM(o.hour) AS h
		        FROM off_table o
		        JOIN staff_tbl s ON s.Id = o.IdStaff
		        WHERE o.Date BETWEEN ? AND DATE_ADD(?, INTERVAL 13 DAY)
		        AND o.enabled = 1
		        GROUP BY s.service, o.off";

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([$startDate, $startDate]);

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$data = [];

		foreach ($rows as $r) {

			$service = $r['service'];
			$code    = $r['off'];

			$data[$service][$code]['count'] = $r['c'];
			$data[$service][$code]['hours'] = $r['h'];

			$data[$service]['totalDays'] =
				($data[$service]['totalDays'] ?? 0) + $r['c'];

			$data[$service]['totalHours'] =
				($data[$service]['totalHours'] ?? 0) + $r['h'];
		}

		return $data;
	} 
    public function saveDayOff($IdStaff, $date, $off, $hour, $observation)
    {
        $sql = "SELECT Id FROM off_table
                WHERE IdStaff = ?
                AND Date = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$IdStaff, $date]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {

            $sql = "UPDATE off_table
                    SET off = ?, hour = ?, observation = ?
                    WHERE Id = ?";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$off, $hour, $observation, $row['Id']]);

        } else {

            $sql = "INSERT INTO off_table
                    (IdStaff, Date, off, hour, observation, enabled)
                    VALUES (?, ?, ?, ?, ?, 1)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$IdStaff, $date, $off, $hour, $observation]);
        }
    }
    public function deleteDayOff($Id)
    {
        $sql = "UPDATE off_table
                SET enabled = 0
                WHERE Id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$Id]);      
    }
    public function getSumOffByDepartement($departement, $startDate)
    {
        $sql = "SELECT s.departement, o.off, COUNT(*) AS c
                FROM off_table o
                JOIN staff_tbl s ON s.Id = o.IdStaff
                WHERE s.departement = ?
                AND o.Date BETWEEN ? AND DATE_ADD(?, INTERVAL 13 DAY)
                AND o.enabled = 1
                GROUP BY s.departement, o.off";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$departement, $startDate, $startDate]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data = [];
        foreach ($rows as $r) {
            $data[$r['off']] = $r['c'];
        }
        return $data;
    }
    public function getStaffListSummaryByDepartement($startDate, $departement)
    {
        $sql = "SELECT s.id, s.service, s.departement, s.Nom,s.Prenom, o.off, COUNT(*) AS c
                FROM off_table o
                JOIN staff_tbl s ON s.Id = o.IdStaff
                WHERE o.Date BETWEEN ? AND DATE_ADD(?, INTERVAL 13 DAY)
                AND o.enabled = 1
                AND s.departement = ?
                GROUP BY s.id, s.service, s.departement, s.Nom, s.Prenom, o.off
                ORDER BY s.service, s.departement, s.Nom, s.Prenom";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$startDate, $startDate, $departement]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [];

        foreach ($rows as $r) {

            $service     = $r['service'];
            $departement = $r['departement'];
            $name        = $r['id'].'#'.$r['Prenom'].' '.$r['Nom'];
            $off         = $r['off'];

            if (!isset($data[$name][$off])) {
                $data[$name][$off] = 0;
            }

            $data[$name][$off] += $r['c'];
        }

        return $data;
    }
        
}