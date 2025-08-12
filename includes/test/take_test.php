<?php
include '../inc/header.php';

$class = $_GET['class'] ?? $_SESSION['test_class'] ?? '';
$subject = $_GET['subject'] ?? $_SESSION['test_subject'] ?? '';
$student_id = $_SESSION['auth_user']['id'] ?? 0;

$_SESSION['test_class'] = $class;
$_SESSION['test_subject'] = $subject;

// Initialize session variables for questions
if (!isset($_SESSION['questions'])) {
    $stmt = $db->prepare("SELECT * FROM questions WHERE class_level = ? AND subject = ? ORDER BY RAND() LIMIT 30");
    $stmt->execute([$class, $subject]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['questions'] = $questions;
    $_SESSION['current_index'] = 0;
    $_SESSION['user_answers'] = [];
    $_SESSION['timer_end'] = time() + 15 * 60; // Set timer end time
}

// Timer calculation
$remaining_seconds = max(0, $_SESSION['timer_end'] - time());
$remaining_minutes = floor($remaining_seconds / 60);
$remaining_seconds_only = $remaining_seconds % 60;

// Handle answer submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qid = $_POST['question_id'];
    $selected_option = $_POST['answer'] ?? '';
    $_SESSION['user_answers'][$qid] = $selected_option;

    if (isset($_POST['previous'])) {
        $_SESSION['current_index'] = max(0, $_SESSION['current_index'] - 1);
    } elseif (isset($_POST['next'])) {
        $_SESSION['current_index']++;
    } elseif (isset($_POST['submit'])) {
        $score = 0;
        $total = count($_SESSION['questions']);

        foreach ($_SESSION['user_answers'] as $question_id => $selected_option) {
            $stmt = $db->prepare("SELECT correct_option FROM questions WHERE id = ?");
            $stmt->execute([$question_id]);
            $correct = $stmt->fetchColumn();

            $is_correct = strtoupper($selected_option) === strtoupper($correct) ? 1 : 0;
            if ($is_correct) $score++;

            // Save to answers table
            $insert = $db->prepare("INSERT INTO answers (student_id, question_id, selected_option, is_correct, subject) VALUES (?, ?, ?, ?, ?)");
            $insert->execute([$student_id, $question_id, strtoupper($selected_option), $is_correct, $subject]);
        }

        // Clear session
        unset($_SESSION['questions'], $_SESSION['current_index'], $_SESSION['user_answers'], $_SESSION['test_class'], $_SESSION['test_subject'], $_SESSION['timer_end']);

        echo "<div class='container mt-5'>
                <div class='alert alert-info'>
                    <h4 class='text-center'>You scored <strong>{$score}</strong> out of <strong>{$total}</strong></h4>
                    <a href='select_subjects.php' class='btn btn-primary mt-3'>Take Another Test</a>
                </div>
              </div>";
        exit;
    }
}

// Load current question
$currentIndex = $_SESSION['current_index'];
$questions = $_SESSION['questions'];
$totalQuestions = count($questions);

// Prevent overflow
if ($currentIndex >= $totalQuestions) {
    $currentIndex = $totalQuestions - 1;
    $_SESSION['current_index'] = $currentIndex;
}

$q = $questions[$currentIndex] ?? null;
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($subject) ?> Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        const timerEnd = <?= $_SESSION['timer_end'] ?> * 1000; // Convert PHP timestamp to JavaScript

        function startTimer() {
            const timerDisplay = document.getElementById('timer');
            const interval = setInterval(function () {
                const now = new Date().getTime();
                const remaining = Math.max(0, Math.floor((timerEnd - now) / 1000));
                const minutes = Math.floor(remaining / 60);
                const seconds = remaining % 60;

                timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                if (remaining <= 0) {
                    clearInterval(interval);
                    alert("Time's up! Submitting your test.");
                    document.querySelector("form").submit();
                }
            }, 1000);
        }

        window.onload = startTimer;
    </script>
</head>
<body>
<div class="container mt-4">
    <h3 class="text-center mb-3"><?= htmlspecialchars($subject) ?> Test - <?= htmlspecialchars($class) ?></h3>
    <div class="alert alert-warning text-center">
        <strong>Time Remaining: <span id="timer"><?= str_pad($remaining_minutes, 2, '0', STR_PAD_LEFT) ?>:<?= str_pad($remaining_seconds_only, 2, '0', STR_PAD_LEFT) ?></span></strong>
    </div>

    <?php if ($q): ?>
        <form method="post" action="">
            <input type="hidden" name="question_id" value="<?= $q['id'] ?>">

            <div class="card mb-3">
                <div class="card-body">
                    <p><strong>Q<?= $currentIndex + 1 ?>:</strong> <?= htmlspecialchars($q['question']) ?></p>
                    <?php foreach (['A', 'B', 'C', 'D'] as $opt): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answer" value="<?= $opt ?>"
                                <?= isset($_SESSION['user_answers'][$q['id']]) && $_SESSION['user_answers'][$q['id']] === $opt ? 'checked' : '' ?> required>
                            <label class="form-check-label"><?= htmlspecialchars($q['option_' . strtolower($opt)]) ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="text-center">
                <?php if ($currentIndex > 0): ?>
                    <button type="submit" name="previous" class="btn btn-secondary me-2">Previous</button>
                <?php endif; ?>

                <?php if ($currentIndex < $totalQuestions - 1): ?>
                    <button type="submit" name="next" class="btn btn-primary">Next</button>
                <?php else: ?>
                    <button type="submit" name="submit" class="btn btn-success">Submit Answers</button>
                <?php endif; ?>
            </div>
        </form>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            No question found.
        </div>
    <?php endif; ?>
</div>
</body>
</html>
<?php require '../inc/footer.php'; ?>