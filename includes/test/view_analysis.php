<?php
include '../inc/header.php';

$userId = $_SESSION['auth_user']['user_Id'] ?? null;

if (!$userId) {
    die("You must be logged in to view analysis.");
}

// Fetch the internal student ID
$stmt = $db->prepare("SELECT id FROM students WHERE userId = ?");
$stmt->execute([$userId]);
$student_id = $stmt->fetchColumn();

if (!$student_id) {
    die("Student ID not found.");
}

// Fetch score analysis
$stmt = $db->prepare("SELECT COUNT(*) AS total, SUM(is_correct) AS correct FROM answers WHERE student_id = ? ");
$stmt->execute([$student_id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$total = $result['total'] ?? 0;
$correct = $result['correct'] ?? 0;
$incorrect = $total - $correct;
$percentage = $total > 0 ? round(($correct / $total) * 100, 2) : 0;

// Optional: Fetch details of each answer
$details = $db->prepare("SELECT a.*, q.question, q.correct_option FROM answers a 
                         JOIN questions q ON a.question_id = q.id 
                         WHERE a.student_id = ?
                         ORDER BY a.id DESC");
$details->execute([$student_id]);
$answers = $details->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Analysis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3 class="text-center mb-4">Test Analysis</h3>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="alert alert-primary text-center">
                <strong>Total Answered</strong><br><?= $total ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="alert alert-success text-center">
                <strong>Correct</strong><br><?= $correct ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="alert alert-danger text-center">
                <strong>Incorrect</strong><br><?= $incorrect ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="alert alert-info text-center">
                <strong>Score</strong><br><?= $percentage ?>%
            </div>
        </div>
    </div>

    <h5 class="mb-3">Answer Details</h5>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Question</th>
            <th>Your Answer</th>
            <th>Correct Answer</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($answers as $index => $row): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($row['question']) ?></td>
                <td><?= $row['selected_option'] ?></td>
                <td><?= $row['correct_option'] ?></td>
                <td>
                    <?php if ($row['is_correct']): ?>
                        <span class="badge bg-success">Correct</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Wrong</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
</body>
</html>
  <?php require '../inc/footer.php'; ?>