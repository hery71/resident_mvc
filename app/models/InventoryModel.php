<?php
class InventoryModel
{
    private PDO $pdo;
    public function __construct(?PDO $pdo = null) { $this->pdo = $pdo ?? $GLOBALS['pdo']; }
    public function departments(): array {
        return $this->pdo->query('SELECT * FROM liste_departement WHERE enabled = 1 ORDER BY departement, id')->fetchAll(PDO::FETCH_ASSOC);
    }
    public function department(int $id): array {
        $s = $this->pdo->prepare('SELECT * FROM liste_departement WHERE id = ? AND enabled = 1');
        $s->execute([$id]);
        return $s->fetch(PDO::FETCH_ASSOC) ?: [];
    }
    public function articles(int $department): array {
        $s = $this->pdo->prepare('SELECT a.*, COALESCE(SUM(r.nb), 0) AS stock FROM inventory_article a
            LEFT JOIN inventory_record r ON r.id_article = a.id AND r.id_departement = a.departement AND r.enabled = 1
            WHERE a.departement = ? AND a.enabled = 1 GROUP BY a.id, a.departement, a.nom, a.item, a.observations, a.enabled ORDER BY a.nom, a.id');
        $s->execute([$department]);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }
    public function article(int $id, int $department): array {
        $s = $this->pdo->prepare('SELECT a.* FROM inventory_article a JOIN liste_departement d ON d.id = a.departement AND d.enabled = 1
            WHERE a.id = ? AND a.departement = ? AND a.enabled = 1');
        $s->execute([$id, $department]);
        return $s->fetch(PDO::FETCH_ASSOC) ?: [];
    }
    public function saveDepartment(int $id, string $name, string $notes): int {
        if ($id) {
            if (!$this->department($id)) throw new InvalidArgumentException('Département introuvable.');
            $s = $this->pdo->prepare('UPDATE liste_departement SET departement = ?, observations = ? WHERE id = ? AND enabled = 1');
            $s->execute([$name, $notes, $id]);
            return $id;
        }
        $s = $this->pdo->prepare('INSERT INTO liste_departement (departement, observations) VALUES (?, ?)');
        $s->execute([$name, $notes]);
        return (int)$this->pdo->lastInsertId();
    }
    public function removeDepartment(int $id): void {
        if (!$this->department($id)) throw new InvalidArgumentException('Département introuvable.');
        $s = $this->pdo->prepare('UPDATE liste_departement SET enabled = 0 WHERE id = ?');
        $s->execute([$id]);
    }
    public function saveArticle(int $id, int $department, string $name, string $notes, string $item = ''): int {
        if (!$this->department($department)) throw new InvalidArgumentException('Choisissez un département actif.');
        if ($id) {
            if (!$this->article($id, $department)) throw new InvalidArgumentException('Article introuvable dans ce département.');
            $s = $this->pdo->prepare('UPDATE inventory_article SET nom = ?, observations = ?, item = ? WHERE id = ? AND departement = ? AND enabled = 1');
            $s->execute([$name, $notes, $item, $id, $department]);
            return $id;
        }
        $s = $this->pdo->prepare('INSERT INTO inventory_article (departement, nom, observations, item) VALUES (?, ?, ?, ?)');
        $s->execute([$department, $name, $notes, $item]);
        return (int)$this->pdo->lastInsertId();
    }
    public function removeArticle(int $id, int $department): void {
        if (!$this->article($id, $department)) throw new InvalidArgumentException('Article introuvable dans ce département.');
        $s = $this->pdo->prepare('UPDATE inventory_article SET enabled = 0 WHERE id = ? AND departement = ?');
        $s->execute([$id, $department]);
    }
    public function addMovement(int $article, int $department, string $date, int $quantity, string $notes): void {
        if (!$this->article($article, $department)) throw new InvalidArgumentException('Article introuvable dans ce département.');
        if ($quantity === 0) throw new InvalidArgumentException('La quantité doit être différente de zéro.');
        $s = $this->pdo->prepare('INSERT INTO inventory_record (id_article, id_departement, `date`, nb, observation) VALUES (?, ?, ?, ?, ?)');
        $s->execute([$article, $department, $date, $quantity, $notes]);
    }
    public function history(int $article, int $department): array {
        if (!$this->article($article, $department)) return [];
        $s = $this->pdo->prepare('SELECT * FROM inventory_record WHERE id_article = ? AND id_departement = ? AND enabled = 1 ORDER BY `date` DESC, id DESC');
        $s->execute([$article, $department]);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }
    public function removeMovement(int $id, int $department): void {
        $s = $this->pdo->prepare('SELECT id_article FROM inventory_record WHERE id = ? AND id_departement = ? AND enabled = 1');
        $s->execute([$id, $department]);
        $article = (int)$s->fetchColumn();
        if (!$article || !$this->article($article, $department)) throw new InvalidArgumentException('Mouvement introuvable dans ce département.');
        $s = $this->pdo->prepare('UPDATE inventory_record SET enabled = 0 WHERE id = ? AND id_departement = ?');
        $s->execute([$id, $department]);
    }
}
