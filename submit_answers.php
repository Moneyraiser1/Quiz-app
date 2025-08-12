<?php
session_start(); // required for $_SESSION['id']
require_once 'Controller/Questions.php';
require_once 'Model/Database.php';

$ctrl = new Question();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $answers = $_POST['answers'] ?? [];
    $subject_id = $_POST['subject_id'] ?? 0;
    $user_id = $_SESSION['id'] ?? null;

    if (!$user_id) {
        die("User not logged in.");
    }

    $question_ids = array_keys($answers);
    $original_questions = $ctrl->fetchQuestionsByIds($question_ids);

    $score = 0;
    $total = count($original_questions);
    $corrections = [];

    foreach ($original_questions as $q) {
        $correct = strtolower(trim($q->correct_option ?? ''));
        $user_ans = strtolower(trim($answers[$q->id] ?? ''));
        $is_correct = ($correct === $user_ans);
        if ($is_correct) $score++;

        $corrections[] = [
            'question' => $q->question,
            'user_answer' => $user_ans,
            'correct_answer' => $correct,
            'options' => [
                'a' => $q->option_a,
                'b' => $q->option_b,
                'c' => $q->option_c,
                'd' => $q->option_d
            ],
            'is_correct' => $is_correct
        ];
    }

    $percentage = $total > 0 ? round(($score / $total) * 100, 2) : 0;

    // Save result to DB
    $db = new Database();
    $db->query("INSERT INTO results (user_id, subject_id, score, total, percentage) 
                VALUES (:user_id, :subject_id, :score, :total, :percentage)");
    $db->bind(':user_id', $user_id);
    $db->bind(':subject_id', $subject_id);
    $db->bind(':score', $score);
    $db->bind(':total', $total);
    $db->bind(':percentage', $percentage);
    $db->execute();
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz Result & Corrections</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="text-center mb-4">
        <h2>Quiz Completed</h2>
        <div class="alert alert-info">
            You scored <strong><?= $score ?></strong> out of <strong><?= $total ?></strong><br>
            Percentage: <strong><?= $percentage ?>%</strong>
        </div>
        <a href="index" class="btn btn-primary mb-3">Go Back</a>
    </div>

    <h4>Corrections</h4>
    <?php foreach ($corrections as $index => $item): ?>
        <div class="card mb-3">
            <div class="card-header">
                <strong>Q<?= $index + 1 ?>:</strong> <?= htmlspecialchars($item['question']) ?>
            </div>
            <div class="card-body">
                <?php foreach ($item['options'] as $key => $text): ?>
                    <p class="mb-1 <?= $key === $item['correct_answer'] ? 'text-success' : ($key === $item['user_answer'] ? 'text-danger' : '') ?>">
                        <strong><?= strtoupper($key) ?>.</strong> <?= htmlspecialchars($text) ?>
                        <?php if ($key === $item['correct_answer']): ?> <span class="badge bg-success">Correct</span> <?php endif; ?>
                        <?php if ($key === $item['user_answer'] && $key !== $item['correct_answer']): ?> <span class="badge bg-danger">Your Answer</span> <?php endif; ?>
                    </p>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
