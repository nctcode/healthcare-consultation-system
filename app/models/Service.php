<?php
class Service extends Model
{
    protected string $table = 'services';

    public function allActive(): array
    {
        return $this->where('status', 'active', 'name ASC');
    }
}
