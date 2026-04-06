<?php
class Role extends Model
{
    protected string $table = 'roles';

    public function findByName(string $name): ?array
    {
        return $this->findBy('name', $name);
    }
}
