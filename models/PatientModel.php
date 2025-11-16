<?php
namespace App\Models;

class PatientModel {
    private $db;
    public function __construct(\PDO $pdo) { $this->db = $pdo; }

    public function exists($id) {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM patient WHERE id = :id');
        $stmt->execute([':id'=>$id]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function create(array $data) {
        $sql = "INSERT INTO patient (id, family_name, given_name, gender, birth_date, phone, nationality, religion, registration_date)
                VALUES (:id,:family,:given,:gender,:birth,:phone,:nationality,:religion,:reg)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'=>$data['id'],
            ':family'=>$data['family_name'] ?? null,
            ':given'=>$data['given_name'] ?? null,
            ':gender'=>$data['gender'] ?? null,
            ':birth'=>$data['birth_date'] ?? null,
            ':phone'=>$data['phone'] ?? null,
            ':nationality'=>$data['nationality'] ?? null,
            ':religion'=>$data['religion'] ?? null,
            ':reg'=>$data['registration_date'] ?? null,
        ]);
    }
}
