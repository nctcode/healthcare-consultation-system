<?php
/**
 * Base Model
 * Cung cấp PDO wrapper và các phương thức CRUD cơ bản
 */
class Model
{
    /** @var PDO Database connection */
    protected static ?PDO $db = null;

    /** @var string Tên bảng */
    protected string $table = '';

    /** @var string Primary key */
    protected string $primaryKey = 'id';

    /**
     * Set database connection (gọi 1 lần từ index.php)
     */
    public static function setDatabase(PDO $pdo): void
    {
        self::$db = $pdo;
    }

    /**
     * Lấy PDO instance
     */
    protected function db(): PDO
    {
        return self::$db;
    }

    /**
     * Lấy tất cả bản ghi
     */
    public function all(string $orderBy = 'id DESC'): array
    {
        $stmt = $this->db()->query("SELECT * FROM {$this->table} ORDER BY {$orderBy}");
        return $stmt->fetchAll();
    }

    /**
     * Tìm bản ghi theo ID
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db()->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Tìm bản ghi theo điều kiện
     */
    public function findBy(string $column, $value): ?array
    {
        $stmt = $this->db()->prepare("SELECT * FROM {$this->table} WHERE {$column} = ?");
        $stmt->execute([$value]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Tìm nhiều bản ghi theo điều kiện
     */
    public function where(string $column, $value, string $orderBy = 'id DESC'): array
    {
        $stmt = $this->db()->prepare("SELECT * FROM {$this->table} WHERE {$column} = ? ORDER BY {$orderBy}");
        $stmt->execute([$value]);
        return $stmt->fetchAll();
    }

    /**
     * Tạo bản ghi mới
     * @return int ID của bản ghi vừa tạo
     */
    public function create(array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $stmt = $this->db()->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})");
        $stmt->execute(array_values($data));

        return (int) $this->db()->lastInsertId();
    }

    /**
     * Cập nhật bản ghi
     */
    public function update(int $id, array $data): bool
    {
        $set = implode(' = ?, ', array_keys($data)) . ' = ?';
        $values = array_values($data);
        $values[] = $id;

        $stmt = $this->db()->prepare("UPDATE {$this->table} SET {$set} WHERE {$this->primaryKey} = ?");
        return $stmt->execute($values);
    }

    /**
     * Xóa bản ghi
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db()->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Đếm tổng bản ghi
     */
    public function count(string $where = '1=1', array $params = []): int
    {
        $stmt = $this->db()->prepare("SELECT COUNT(*) FROM {$this->table} WHERE {$where}");
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Truy vấn SQL tùy chỉnh
     */
    public function query(string $sql, array $params = []): array
    {
        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Truy vấn SQL trả về 1 dòng
     */
    public function queryOne(string $sql, array $params = []): ?array
    {
        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Truy vấn SQL trả về 1 giá trị
     */
    public function queryScalar(string $sql, array $params = [])
    {
        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    /**
     * Phân trang
     */
    public function paginate(int $page = 1, int $perPage = ITEMS_PER_PAGE, string $where = '1=1', array $params = [], string $orderBy = 'id DESC'): array
    {
        $offset = ($page - 1) * $perPage;
        $total = $this->count($where, $params);
        $totalPages = (int) ceil($total / $perPage);

        $stmt = $this->db()->prepare(
            "SELECT * FROM {$this->table} WHERE {$where} ORDER BY {$orderBy} LIMIT {$perPage} OFFSET {$offset}"
        );
        $stmt->execute($params);
        $data = $stmt->fetchAll();

        return [
            'data'        => $data,
            'total'       => $total,
            'page'        => $page,
            'perPage'     => $perPage,
            'totalPages'  => $totalPages,
        ];
    }
}
