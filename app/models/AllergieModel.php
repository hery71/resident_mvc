<?php
class AllergieModel extends JsonRepository
{
    private string $file;

    public function __construct()
    {
        $this->file = dirname(__DIR__, 2) . '/storage/data/allergies.json';
    }

    public function all(): array
    {
        return $this->read($this->file); 
    }
    public function saveAll(array $allergies): void
    {
        $cleaned = array_unique(array_filter(array_map('trim', $allergies)));
        sort($cleaned);
        $this->write($this->file, array_values($cleaned));
    }
}