<?php
class InventaireController
{
    private function id($value): int {
        if (!is_scalar($value) || filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 4294967295]]) === false)
            throw new InvalidArgumentException('Identifiant invalide.');
        return (int)$value;
    }
    private function text(string $field, int $limit, bool $required = false): string {
        $value = $_POST[$field] ?? '';
        if (!is_string($value)) throw new InvalidArgumentException('Texte invalide.');
        $value = trim($value);
        if (($required && $value === '') || preg_match('/\A.{0,' . $limit . '}\z/us', $value) !== 1)
            throw new InvalidArgumentException('Vérifiez les champs : nom obligatoire et longueur maximale respectée.');
        return $value;
    }
    public function inventoryIndexPrint(): void {
        if (!Auth::check()) { header('Location: /auth/login'); return; }
        try {
            $selected = $this->id($_GET['departement'] ?? 0);
        } catch (InvalidArgumentException $exception) {
            http_response_code(400); echo 'Département invalide.'; return;
        }
        $model = new InventoryModel();
        $department = $model->department($selected);
        if (!$department) { http_response_code(404); echo 'Département introuvable.'; return; }
        $articles = $model->articles($selected);
        require __DIR__ . '/../views/inventaire/inventoryIndexPrint.php';
    }
    public function inventoryHistoryPrint(): void {
        if (!Auth::check()) { header('Location: /auth/login'); return; }
        try {
            $selected = $this->id($_GET['departement'] ?? 0);
            $articleId = $this->id($_GET['article'] ?? 0);
        } catch (InvalidArgumentException $exception) {
            http_response_code(400); echo 'Identifiant invalide.'; return;
        }
        $model = new InventoryModel();
        $department = $model->department($selected);
        $article = $model->article($articleId, $selected);
        if (!$department || !$article) { http_response_code(404); echo 'Article introuvable dans ce département.'; return; }
        $history = $model->history($articleId, $selected);
        $stock = array_sum(array_column($history, 'nb'));
        require __DIR__ . '/../views/inventaire/inventoryHistoryPrint.php';
    }
    public function inventoryEvolutionPrint(): void {
        if (!Auth::check()) { header('Location: /auth/login'); return; }
        try {
            $selected = $this->id($_GET['departement'] ?? 0);
            $articleId = $this->id($_GET['article'] ?? 0);
        } catch (InvalidArgumentException $exception) {
            http_response_code(400); echo 'Identifiant invalide.'; return;
        }
        $model = new InventoryModel();
        $department = $model->department($selected);
        $article = $model->article($articleId, $selected);
        if (!$department || !$article) { http_response_code(404); echo 'Article introuvable dans ce département.'; return; }
        $evolution = [];
        $stock = 0;
        foreach (array_reverse($model->history($articleId, $selected)) as $movement) {
            $stock += (int)$movement['nb'];
            $movement['stock'] = $stock;
            $evolution[] = $movement;
        }
        require __DIR__ . '/../views/inventaire/inventoryEvolutionPrint.php';
    }
    public function index(): void {
        if (!Auth::check()) { header('Location: /auth/login'); return; }
        $model = new InventoryModel();
        $error = '';
        $modal = '';
        $selected = 0;
        $historyId = 0;
        $evolutionId = 0;
        try {
            $selected = $this->id($_GET['departement'] ?? 0);
            $historyId = $this->id($_GET['article'] ?? 0);
            $evolutionId = $this->id($_GET['evolution'] ?? 0);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!is_string($_POST['token'] ?? null) || !Auth::checkToken($_POST['token'])) {
                    http_response_code(403); echo 'Token CSRF invalide. Rechargez la page.'; return;
                }
                $selected = $this->id($_POST['departement_id'] ?? 0);
                $operation = $_POST['operation'] ?? '';
                $id = $this->id($_POST['id'] ?? 0);
                switch ($operation) {
                    case 'department_save':
                        $modal = 'departmentsModal';
                        $newId = $model->saveDepartment($id, $this->text('nom', 150, true), $this->text('observations', 4000));
                        if (!$selected) $selected = $newId;
                        break;
                    case 'department_remove':
                        $modal = 'departmentsModal'; $model->removeDepartment($id);
                        if ($selected === $id) $selected = 0;
                        break;
                    case 'article_save':
                        $modal = 'articleModal';
                        $articleDepartment = $this->id($_POST['article_departement'] ?? $selected);
                        if ($id && $articleDepartment !== $selected) throw new InvalidArgumentException('Le département d’un article existant ne peut pas être changé.');
                        $model->saveArticle($id, $articleDepartment, $this->text('nom', 200, true), $this->text('observations', 4000));
                        $selected = $articleDepartment;
                        break;
                    case 'article_remove': $model->removeArticle($id, $selected); break;
                    case 'movement_add':
                        $modal = 'movementModal';
                        $article = $this->id($_POST['id_article'] ?? 0);
                        $date = $this->text('date', 10, true);
                        $parsed = DateTimeImmutable::createFromFormat('!Y-m-d', $date);
                        if (!$parsed || $parsed->format('Y-m-d') !== $date || $date < '1000-01-01') throw new InvalidArgumentException('Date invalide.');
                        $quantity = $_POST['nb'] ?? null;
                        if (!is_string($quantity) || !preg_match('/\A[+-]?\d+\z/', $quantity) ||
                            filter_var(ltrim($quantity, '+'), FILTER_VALIDATE_INT, ['options' => ['min_range' => -2147483648, 'max_range' => 2147483647]]) === false || (int)$quantity === 0)
                            throw new InvalidArgumentException('Saisissez une quantité entière non nulle, positive pour une entrée ou négative pour une sortie.');
                        $model->addMovement($article, $selected, $date, (int)$quantity, $this->text('observation', 4000));
                        break;
                    case 'movement_remove': $model->removeMovement($id, $selected); break;
                    default: throw new InvalidArgumentException('Action inconnue.');
                }
                $_SESSION['inventory_message'] = 'Enregistrement effectué.';
                $url = '/inventaire/index?departement=' . $selected;
                if ($modal === 'departmentsModal') $url .= '&departements=1';
                header('Location: ' . $url, true, 303); return;
            }
        } catch (InvalidArgumentException $exception) {
            http_response_code(422); $error = $exception->getMessage();
        } catch (PDOException $exception) {
            error_log('Inventory write failed: ' . $exception->getMessage());
            http_response_code(500); $error = 'Enregistrement impossible. Réessayez.';
        }
        $departments = $model->departments();
        $department = $model->department($selected);
        if (!$department && $departments) { $selected = (int)$departments[0]['id']; $department = $departments[0]; }
        if (!$department) $selected = 0;
        $articles = $selected ? $model->articles($selected) : [];
        $historyArticle = $historyId ? $model->article($historyId, $selected) : [];
        $history = $historyArticle ? $model->history($historyId, $selected) : [];
        $evolutionArticle = $evolutionId ? $model->article($evolutionId, $selected) : [];
        $evolution = [];
        $evolutionStock = 0;
        if ($evolutionArticle) {
            foreach (array_reverse($model->history($evolutionId, $selected)) as $movement) {
                $evolutionStock += (int)$movement['nb'];
                $movement['stock'] = $evolutionStock;
                $evolution[] = $movement;
            }
        }
        if ($error === '' && isset($_GET['departements'])) $modal = 'departmentsModal';
        if ($historyArticle) $modal = 'historyModal';
        if ($evolutionArticle) $modal = 'evolutionModal';
        $message = $_SESSION['inventory_message'] ?? '';
        unset($_SESSION['inventory_message']);
        $token = Auth::generateToken();
        require __DIR__ . '/../views/inventaire/index.php';
    }
}
