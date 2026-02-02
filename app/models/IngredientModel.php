<?php
class IngredientModel extends JsonRepository
{
    private string $file;

    public function __construct()
    {
        $this->file = dirname(__DIR__, 2) . '/storage/data/ingredients.json';
    }

    public function all(): array
    {
        return $this->read($this->file); 
    }
    public function saveAll(array $ingredients): void
    {
        $cleaned = array_unique(array_filter(array_map('trim', $ingredients)));
        sort($cleaned);
        $this->write($this->file, array_values($cleaned));
    }
}