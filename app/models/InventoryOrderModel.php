<?php
class InventoryOrderModel
{
    private PDO $pdo;
    public function __construct(?PDO $pdo = null) { $this->pdo = $pdo ?? $GLOBALS['pdo']; }
    public function all(): array {
        return $this->pdo->query('SELECT * FROM inventory_order_request ORDER BY updated_at DESC, id DESC')->fetchAll(PDO::FETCH_ASSOC);
    }
    public function unread(): array {
        return $this->pdo->query("SELECT * FROM inventory_order_request WHERE statut = 'envoyee' AND consulted_at IS NULL ORDER BY sent_at DESC, id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function find(int $id): array {
        $s = $this->pdo->prepare('SELECT * FROM inventory_order_request WHERE id = ?');
        $s->execute([$id]); return $s->fetch(PDO::FETCH_ASSOC) ?: [];
    }
    public function lines(int $id): array {
        $s = $this->pdo->prepare('SELECT * FROM inventory_order_request_line WHERE id_request = ? ORDER BY nom_article, id');
        $s->execute([$id]); return $s->fetchAll(PDO::FETCH_ASSOC);
    }
    public function markRead(int $id): void {
        $s = $this->pdo->prepare("UPDATE inventory_order_request SET consulted_at = COALESCE(consulted_at, CURRENT_TIMESTAMP) WHERE id = ? AND statut = 'envoyee'");
        $s->execute([$id]);
    }
    public function save(int $id, int $version, int $department, string $name, string $requester, array $quantities, bool $send): int {
        if ($name === '' || preg_match('/\A.{1,200}\z/us', $name) !== 1) throw new InvalidArgumentException('Le nom de la commande est obligatoire (200 caractères maximum).');
        if (preg_match('/\A.{0,200}\z/us', $requester) !== 1 || ($send && $requester === '')) throw new InvalidArgumentException('Indiquez le nom du demandeur avant l’envoi (200 caractères maximum).');
        $this->pdo->beginTransaction();
        try {
            if ($id) {
                $s = $this->pdo->prepare('SELECT * FROM inventory_order_request WHERE id = ? FOR UPDATE');
                $s->execute([$id]); $existing = $s->fetch(PDO::FETCH_ASSOC);
                if (!$existing || $existing['statut'] !== 'brouillon') throw new InvalidArgumentException('Cette commande ne peut plus être modifiée.');
                if ((int)$existing['version'] !== $version) throw new InvalidArgumentException('Cette commande a été modifiée ailleurs. Rechargez-la avant de continuer.');
                if ((int)$existing['id_departement'] !== $department) throw new InvalidArgumentException('Le département d’un brouillon ne peut pas être changé.');
            }
            $inventory = new InventoryModel($this->pdo);
            $dept = $inventory->department($department);
            if (!$dept) throw new InvalidArgumentException('Choisissez un département actif.');
            $articles = [];
            foreach ($inventory->articles($department) as $article) $articles[(int)$article['id']] = $article;
            $lines = [];
            foreach ($quantities as $key => $value) {
                if (!is_string($value) || !preg_match('/\A\d{1,10}\z/', $value) || (float)$value > 2147483647) throw new InvalidArgumentException('Les quantités doivent être des nombres entiers de 0 à 2147483647.');
                if ((int)$value === 0) continue;
                if (!ctype_digit((string)$key) || !isset($articles[(int)$key])) throw new InvalidArgumentException('Un article demandé n’est plus actif dans ce département.');
                $lines[] = [$articles[(int)$key], (int)$value];
            }
            if ($send && !$lines) throw new InvalidArgumentException('Indiquez au moins une quantité supérieure à zéro avant l’envoi.');
            $status = $send ? 'envoyee' : 'brouillon';
            if ($id) {
                $s = $this->pdo->prepare('UPDATE inventory_order_request SET nom = ?, demandeur = ?, departement_nom = ?, statut = ?, sent_at = ?, updated_at = CURRENT_TIMESTAMP, version = version + 1 WHERE id = ?');
                $s->execute([$name, $requester, $dept['departement'], $status, $send ? date('Y-m-d H:i:s') : null, $id]);
                $s = $this->pdo->prepare('DELETE FROM inventory_order_request_line WHERE id_request = ?'); $s->execute([$id]);
            } else {
                $s = $this->pdo->prepare('INSERT INTO inventory_order_request (id_departement, departement_nom, nom, demandeur, statut, sent_at) VALUES (?, ?, ?, ?, ?, ?)');
                $s->execute([$department, $dept['departement'], $name, $requester, $status, $send ? date('Y-m-d H:i:s') : null]);
                $id = (int)$this->pdo->lastInsertId();
            }
            $s = $this->pdo->prepare('INSERT INTO inventory_order_request_line (id_request, id_article, nom_article, item, quantite) VALUES (?, ?, ?, ?, ?)');
            foreach ($lines as [$article, $quantity]) $s->execute([$id, $article['id'], $article['nom'], $article['item'], $quantity]);
            $this->pdo->commit(); return $id;
        } catch (Throwable $e) { if ($this->pdo->inTransaction()) $this->pdo->rollBack(); throw $e; }
    }
}
