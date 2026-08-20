<?php
require_once __DIR__ . '/database.php';

class DBSessionHandler implements SessionHandlerInterface {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function open(string $path, string $name): bool {
        return true;
    }

    public function close(): bool {
        return true;
    }

    public function read(string $id): string|false {
        $stmt = $this->db->prepare("SELECT data FROM sessions WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? $row['data'] : '';
    }

    public function write(string $id, string $data): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO sessions (id, data, last_access) VALUES (?, ?, NOW())
             ON DUPLICATE KEY UPDATE data = ?, last_access = NOW()"
        );
        return $stmt->execute([$id, $data, $data]);
    }

    public function destroy(string $id): bool {
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function gc(int $max_lifetime): int|false {
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE last_access < NOW() - INTERVAL ? SECOND");
        $stmt->execute([$max_lifetime]);
        return $stmt->rowCount();
    }
}

$db = (new Database())->getConnection();

if ($db) {
    session_set_save_handler(new DBSessionHandler($db));
}