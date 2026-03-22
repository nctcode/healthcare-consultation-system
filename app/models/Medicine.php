<?php
class Medicine extends Model
{
    protected string $table = 'medicines';

    public function allActive(): array
    {
        return $this->where('status', 'active', 'name ASC');
    }

    public function search(string $keyword): array
    {
        return $this->query(
            "SELECT * FROM medicines WHERE name LIKE ? OR generic_name LIKE ? ORDER BY name",
            ["%{$keyword}%", "%{$keyword}%"]
        );
    }

    public function countAll(): int
    {
        return $this->count();
    }
}
