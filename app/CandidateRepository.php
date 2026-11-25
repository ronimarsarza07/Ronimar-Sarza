<?php
namespace App;
use PDO;
final class CandidateRepository {
    public function __construct(private PDO $db) {}
    public function all(string $search = ''): array {
        if ($search === '') return $this->db->query('SELECT * FROM candidates WHERE deleted_at IS NULL ORDER BY created_at DESC')->fetchAll();
        $stmt = $this->db->prepare('SELECT * FROM candidates WHERE deleted_at IS NULL AND (name LIKE :nameq OR position LIKE :positionq OR party LIKE :partyq) ORDER BY created_at DESC');
        $term = '%' . $search . '%';
        $stmt->execute(['nameq' => $term, 'positionq' => $term, 'partyq' => $term]);
        return $stmt->fetchAll();
    }
    public function find(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM candidates WHERE id = ? AND deleted_at IS NULL'); $stmt->execute([$id]);
        $row = $stmt->fetch(); return $row ?: null;
    }
    public function create(array $data): void {
        $stmt = $this->db->prepare('INSERT INTO candidates (name, position, party, platform) VALUES (:name, :position, :party, :platform)'); $stmt->execute($data);
    }
    public function update(int $id, array $data): void {
        $data['id'] = $id; $stmt = $this->db->prepare('UPDATE candidates SET name=:name, position=:position, party=:party, platform=:platform WHERE id=:id AND deleted_at IS NULL'); $stmt->execute($data);
    }
    public function archive(int $id): void {
        $stmt = $this->db->prepare('UPDATE candidates SET deleted_at = CURRENT_TIMESTAMP WHERE id = ? AND deleted_at IS NULL'); $stmt->execute([$id]);
    }
}
