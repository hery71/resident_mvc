<?php
class InventaireCommandesController
{
    private function authenticated(): bool {
        if (!Auth::check()) { header('Location: /auth/login'); return false; } return true;
    }
    private function id($value): int {
        if (!is_scalar($value) || filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 4294967295]]) === false) throw new InvalidArgumentException('Identifiant invalide.');
        return (int)$value;
    }
    public function index(): void {
        if (!$this->authenticated()) return;
        $orders = (new InventoryOrderModel())->all();
        $message = $_SESSION['inventory_order_message'] ?? ''; unset($_SESSION['inventory_order_message']);
        require __DIR__ . '/../views/inventaireCommandes/index.php';
    }
    public function form(): void {
        if (!$this->authenticated()) return;
        $model = new InventoryOrderModel(); $inventory = new InventoryModel();
        $error = ''; $order = []; $quantities = []; $name = ''; $requester = ''; $id = 0; $department = 0; $version = 0;
        try {
            $id = $this->id($_GET['id'] ?? 0);
            if ($id) {
                $order = $model->find($id);
                if (!$order) { http_response_code(404); echo 'Commande introuvable.'; return; }
                if ($order['statut'] !== 'brouillon') { header('Location: /inventaireCommandes/view?id=' . $id); return; }
                $department = (int)$order['id_departement']; $version = (int)$order['version'];
                $name = $order['nom']; $requester = $order['demandeur'];
                foreach ($model->lines($id) as $line) $quantities[(int)$line['id_article']] = (string)$line['quantite'];
            } else $department = $this->id($_GET['departement'] ?? 0);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!is_string($_POST['token'] ?? null) || !Auth::checkToken($_POST['token'])) { http_response_code(403); echo 'Token CSRF invalide. Rechargez la page.'; return; }
                $department = $this->id($_POST['departement'] ?? 0);
                $version = $this->id($_POST['version'] ?? 0);
                $name = is_string($_POST['nom'] ?? null) ? trim($_POST['nom']) : '';
                $requester = is_string($_POST['demandeur'] ?? null) ? trim($_POST['demandeur']) : '';
                $quantities = $_POST['quantites'] ?? [];
                if (!is_array($quantities)) { $quantities = []; throw new InvalidArgumentException('Quantités invalides.'); }
                $action = $_POST['action'] ?? '';
                if (!in_array($action, ['save', 'send'], true)) throw new InvalidArgumentException('Action invalide.');
                $savedId = $model->save($id, $version, $department, $name, $requester, $quantities, $action === 'send');
                $_SESSION['inventory_order_message'] = $action === 'send' ? 'Commande envoyée. Elle est maintenant disponible sur le dashboard.' : 'Brouillon enregistré.';
                header('Location: /inventaireCommandes/' . ($action === 'send' ? 'view?id=' . $savedId : 'index'), true, 303); return;
            }
        } catch (InvalidArgumentException $e) { http_response_code(422); $error = $e->getMessage(); }
        catch (PDOException $e) { error_log('Inventory order: ' . $e->getMessage()); http_response_code(500); $error = 'Enregistrement impossible. Réessayez.'; }
        $departments = $inventory->departments();
        $articles = $department && $inventory->department($department) ? $inventory->articles($department) : [];
        // Keep the database A-Z ordering within each quantity group.
        $zeroQuantityArticles = [];
        $orderedArticles = [];
        foreach ($articles as $article) {
            $quantity = $quantities[(int)$article['id']] ?? '0';
            if (is_scalar($quantity) && (int)$quantity === 0) $zeroQuantityArticles[] = $article;
            else $orderedArticles[] = $article;
        }
        $articles = array_merge($orderedArticles, $zeroQuantityArticles);
        $inactiveLines = [];
        $activeIds = array_column($articles, 'id');
        if ($id) foreach ($model->lines($id) as $line) if (!in_array($line['id_article'], $activeIds)) $inactiveLines[] = $line;
        $token = $_SESSION['token'] ?? Auth::generateToken();
        require __DIR__ . '/../views/inventaireCommandes/form.php';
    }
    public function view(): void { $this->display(false); }
    public function print(): void { $this->display(true); }
    private function display(bool $print): void {
        if (!$this->authenticated()) return;
        try { $id = $this->id($_GET['id'] ?? 0); } catch (InvalidArgumentException $e) { http_response_code(400); echo 'Identifiant invalide.'; return; }
        $model = new InventoryOrderModel(); $order = $model->find($id);
        if (!$order) { http_response_code(404); echo 'Commande introuvable.'; return; }
        $lines = $model->lines($id);
        if (!$print && ($_GET['dashboard'] ?? '') === '1' && $order['statut'] === 'envoyee') $model->markRead($id);
        $message = $_SESSION['inventory_order_message'] ?? ''; unset($_SESSION['inventory_order_message']);
        require __DIR__ . '/../views/inventaireCommandes/view.php';
    }
}
