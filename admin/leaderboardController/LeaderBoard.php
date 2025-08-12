<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../../Model/Database.php";

class LeaderBoard {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // ✅ Fetch unique subjects from questions table
    public function fetchAllSubjects() {
        $this->db->query("SELECT * FROM questions ORDER BY subject ASC");
        return $this->db->resultSetObj();
    }

    // ✅ Fetch leaderboard
 public function getLeaderboard($subject_id = null) {
    if ($subject_id) {
        $this->db->query("
        
            SELECT s.category, u.username AS student_name, r.score, r.total, r.percentage, r.taken_at, s.category AS subject_name
            FROM results r
            JOIN users u ON r.user_id = u.id
            JOIN category s ON r.subject_id = s.id
            WHERE s.id = :subject_id
            ORDER BY r.percentage DESC
        ");
        $this->db->bind(':subject_id', $subject_id);
        return $this->db->resultSetObj();
    } else {
        $this->db->query("
            SELECT s.category, u.username AS student_name, r.percentage
            FROM results r
            JOIN users u ON r.user_id = u.id
            JOIN category s ON r.subject_id = s.id
            ORDER BY s.category
        ");
        $results = $this->db->resultSetObj();

        // Group by subject
        $grouped = [];
        foreach ($results as $row) {
            $grouped[$row->category][] = $row;
        }
        return $grouped;
    }
}

public function getStudentAverages() {
    $this->db->query("
        SELECT 
            s.username AS student_name,
            AVG(q.percentage) AS mean_percentage
        FROM quiz_results q
        JOIN users s ON q.user_id = s.id
        GROUP BY q.user_id
        ORDER BY mean_percentage DESC
    ");
    return $this->db->resultSet();
}


}
