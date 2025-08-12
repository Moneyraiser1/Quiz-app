<?php
require_once __DIR__."/../Model/Database.php";

class Question
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function fetchAllSubjects()
    {
        $this->db->query("SELECT * FROM questions ORDER BY subject ASC");
        return $this->db->resultSetObj();
    }

    public function fetchRandomQuestions($subjectId, $limit)
    {
        $this->db->query("SELECT * FROM questions WHERE id = :sid ORDER BY RAND() LIMIT :lim");
        $this->db->bind(':sid', $subjectId);
        $this->db->bind(':lim', (int)$limit, PDO::PARAM_INT);
        return $this->db->resultSetObj();
    }
    public function fetchQuestionsByIds(array $ids)
{
    if (empty($ids)) {
        return [];
    }

    // Convert array to comma-separated placeholders like :id0, :id1...
    $placeholders = [];
    foreach ($ids as $index => $id) {
        $placeholders[] = ":id$index";
    }

    $sql = "SELECT * FROM questions WHERE id IN (" . implode(',', $placeholders) . ")";
    $this->db->query($sql);

    // Bind each ID
    foreach ($ids as $index => $id) {
        $this->db->bind(":id$index", $id);
    }

    return $this->db->resultSetObj(); // Assuming you're using a custom Database class with resultSet()
}
public function saveResult($user_id, $subject_id, $score, $total, $percentage) {
    $sql = "INSERT INTO quiz_results (user_id, subject_id, score, total, percentage) 
            VALUES (:user_id, :subject_id, :score, :total, :percentage)";
    $this->db->query($sql);
    $this->db->bind(':user_id', $user_id);
    $this->db->bind(':subject_id', $subject_id);
    $this->db->bind(':score', $score);
    $this->db->bind(':total', $total);
    $this->db->bind(':percentage', $percentage);
    $this->db->execute();
}

}
