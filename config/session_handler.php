<?php
require_once __DIR__ . '/database.php';

$db = (new Database())->getConnection();

if ($db) {
    session_set_save_handler(
        function() { return true; },
        function() { return true; },
        function($id) use ($db) {
            $stmt = $db->prepare("SELECT data FROM sessions WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            return $row ? $row['data'] : '';
        },
        function($id, $data) use ($db) {
            $stmt = $db->prepare(
                "INSERT INTO sessions (id, data, last_access) VALUES (?, ?, NOW())
                 ON DUPLICATE KEY UPDATE data = VALUES(data), last_access = NOW()"
            );
            return $stmt->execute([$id, $data]);
        },
        function($id) use ($db) {
            $stmt = $db->prepare("DELETE FROM sessions WHERE id = ?");
            return $stmt->execute([$id]);
        },
        function($maxlifetime) use ($db) {
            $stmt = $db->prepare("DELETE FROM sessions WHERE last_access < NOW() - INTERVAL ? SECOND");
            return $stmt->execute([$maxlifetime]);
        }
    );

    session_register_shutdown();
}
