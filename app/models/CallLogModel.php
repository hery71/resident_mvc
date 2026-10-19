<?php
require_once dirname(__DIR__, 2) . '/app/config/db.php';

class CallLogModel
{
    public static function phoneNumbers(array $resident): array
    {
        $numbers = [];
        foreach (['Tel1', 'Tel2', 'Tel3'] as $field) {
            $number = trim((string)($resident[$field] ?? ''));
            if ($number !== '' && !in_array(strtolower($number), ['nc', 'ns', 'n/a'], true)) {
                $numbers[$field] = $number;
            }
        }
        return $numbers;
    }

    public function insert(array $data): int
    {
        $pdo = $GLOBALS['pdo'];
        $stmt = $pdo->prepare('INSERT INTO appel_log_tbl
            (id_anniversaire, id_user, date_appel, Etat, numero, enabled, date_rappel,
             controller_name, method_name, view_name)
            VALUES (:anniversaire, :user, :date_appel, :etat, :numero, 1, :date_rappel,
                    :controller, :method, :view)');
        $stmt->execute($data);
        return (int)$pdo->lastInsertId();
    }

    public function getByBirthday(int $id): array
    {
        $stmt = $GLOBALS['pdo']->prepare('SELECT l.*, u.Login AS user_name
            FROM appel_log_tbl l LEFT JOIN users u ON u.Id = l.id_user
            WHERE l.id_anniversaire = :id AND l.enabled = 1
            ORDER BY l.date_appel DESC, l.Id DESC');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
