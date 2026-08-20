<?php
require_once __DIR__ . '/database.php';

class DBSessionHandler implements SessionHandlerInterface {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function open($savePath, $sessionName) {
        return true;
    }

    public function close() {
        return true;
    }

    public function read($id) {
        $stmt = $this->db->prepare("SELECT data FROM sessions WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? $row['data'] : '';
    }

    public function write($id, $data) {
        $stmt = $this->db->prepare(
            "INSERT INTO sessions (id, data, last_access) VALUES (?, ?, NOW())
             ON DUPLICATE KEY UPDATE data = ?, last_access = NOW()"
        );
        return $stmt->execute([$id, $data, $data]);
    }

    public function destroy($id) {
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function gc($maxlifetime) {
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE last_access < NOW() - INTERVAL ? SECOND");
        return $stmt->execute([$maxlifetime]);
    }
}

$db = (new Database())->getConnection();

if ($db) {
    session_set_save_handler(new DBSessionHandler($db));
}