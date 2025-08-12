<?php
require_once 'Controller/Questions.php';
require_once 'includes/header.php';

if (!isset($_GET['subject_id'], $_GET['limit'], $_GET['time'])) {
    die("Missing parameters.");
}

$subject_id = (int)$_GET['subject_id'];
$limit = (int)$_GET['limit'];
$time = (int)$_GET['time'];

$ctrl = new Question();
$questions = $ctrl->fetchRandomQuestions($subject_id, $limit);
?>
<style>
      .nav-square {
    width: 40px;
    height: 40px;
    line-height: 38px;
    text-align: center;
    border: 2px solid #ccc;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    user-select: none;
    transition: 0.2s ease;
}
.nav-square:hover {
    background-color: #e2e6ea;
}
.nav-square.answered {
    background-color: #28a745;
    color: white;
    border-color: #28a745;
}
.nav-square.unanswered {
    background-color: #ffc107;
    color: #212529;
    border-color: #ffc107;
}

</style>

<body class="bg-light">
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary">Quiz In Progress</h3>
        <div id="timer" class="fs-4 fw-bold text-danger"></div>
    </div>

    <form method="post" action="submit_answers" id="quiz-form">
        <input type="hidden" name="subject_id" value="<?= $subject_id ?>">

        <?php foreach ($questions as $index => $q): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">
                    Question <?= $index + 1 ?>
                </div>
                <div class="card-body p-5">
                    <p class="mb-3"><?= htmlspecialchars($q->question) ?></p>
                    <div class="row">
                        <?php
                        $options = ['A' => $q->option_a, 'B' => $q->option_b, 'C' => $q->option_c, 'D' => $q->option_d];
                        foreach ($options as $letter => $text): ?>
                            <div class="col-md-6 mb-2">
                                <div class="form-check border rounded p-3 hover-effect bg-white option-block">
                                    <input class="form-check-input d-none" type="radio" name="answers[<?= $q->id ?>]" id="q<?= $q->id . $letter ?>" value="<?= $letter ?>">
                                    <label class="form-check-label w-100 h-100" for="q<?= $q->id . $letter ?>">
                                        <strong><?= $letter ?>.</strong> <?= htmlspecialchars($text) ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="sticky-bottom bg-light py-3 text-center border-top">
            <button type="submit" class="btn btn-lg btn-success px-5">Submit Quiz</button>
        </div>
        <hr class="my-4">

<div class="text-center mb-5">
    <h5 class="mb-3">Jump to Question</h5>
    <div id="question-nav" class="d-flex flex-wrap justify-content-center gap-2">
        <?php for ($i = 0; $i < count($questions); $i++): ?>
            <div class="nav-square unanswered" data-target="<?= $i ?>">
                <?= $i + 1 ?>
            </div>
        <?php endfor; ?>
    </div>
</div>

    </form>
</div>

<style>
    .option-block {
        transition: background-color 0.2s ease, border-color 0.2s ease;
        cursor: pointer;
    }
    .option-block:hover {
        background-color: #f8f9fa;
        border-color: #0d6efd;
    }
    .form-check-input:checked + .form-check-label {
        background-color: #e9f5ff;
        border-color: #0d6efd;
        font-weight: bold;
    }
</style>


<script>
const subjectId = <?= $subject_id ?>;
const totalTime = <?= $time ?> * 60;
const quizKey = 'quiz_timer_' + subjectId;
let endTime;

if (localStorage.getItem(quizKey)) {
    endTime = parseInt(localStorage.getItem(quizKey));
} else {
    endTime = Math.floor(Date.now() / 1000) + totalTime;
    localStorage.setItem(quizKey, endTime);
}

const timer = setInterval(() => {
    const currentTime = Math.floor(Date.now() / 1000);
    let remaining = endTime - currentTime;

    if (remaining <= 0) {
        clearInterval(timer);
        localStorage.removeItem(quizKey);
        alert("Time is up! Submitting now.");
        document.getElementById('quiz-form').submit();
    } else {
        const minutes = Math.floor(remaining / 60);
        const seconds = remaining % 60;
        document.getElementById('timer').textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
    }
}, 1000);

document.getElementById('quiz-form').addEventListener('submit', () => {
    localStorage.removeItem(quizKey);
});
// Highlight answered questions on radio change
document.querySelectorAll('input[type="radio"]').forEach(input => {
    input.addEventListener('change', function () {
        const qid = this.name.match(/\d+/)[0]; // question ID
        const square = document.querySelector(`.nav-square[data-target="${getQuestionIndex(qid)}"]`);
        if (square) {
            square.classList.remove('unanswered');
            square.classList.add('answered');
        }
    });
});

// Jump to question on nav square click
document.querySelectorAll('.nav-square').forEach(square => {
    square.addEventListener('click', function () {
        const target = parseInt(this.dataset.target);
        const questionCards = document.querySelectorAll('.card');
        window.scrollTo({
            top: questionCards[target].offsetTop - 80,
            behavior: 'smooth'
        });
    });
});

// Helper to get index of question by ID
function getQuestionIndex(qid) {
    const ids = Array.from(document.querySelectorAll('[name^="answers["]')).map(el => el.name.match(/\d+/)[0]);
    return ids.indexOf(qid);
}
const answerKey = 'quiz_answers_' + subjectId;

// Save answer when changed
document.querySelectorAll('input[type="radio"]').forEach(input => {
    input.addEventListener('change', function () {
        const answers = JSON.parse(localStorage.getItem(answerKey)) || {};
        answers[this.name] = this.value;
        localStorage.setItem(answerKey, JSON.stringify(answers));

        // Mark question as answered
        const qid = this.name.match(/\d+/)[0];
        const square = document.querySelector(`.nav-square[data-target="${getQuestionIndex(qid)}"]`);
        if (square) {
            square.classList.remove('unanswered');
            square.classList.add('answered');
        }
    });
});


window.addEventListener('DOMContentLoaded', () => {
    const savedAnswers = JSON.parse(localStorage.getItem(answerKey)) || {};

    Object.entries(savedAnswers).forEach(([name, value]) => {
        const input = document.querySelector(`input[name="${name}"][value="${value}"]`);
        if (input) {
            input.checked = true;

            // Visually select nav square
            const qid = name.match(/\d+/)[0];
            const square = document.querySelector(`.nav-square[data-target="${getQuestionIndex(qid)}"]`);
            if (square) {
                square.classList.remove('unanswered');
                square.classList.add('answered');
            }
        }
    });
});
document.getElementById('quiz-form').addEventListener('submit', () => {
    localStorage.removeItem(quizKey);     // timer
    localStorage.removeItem(answerKey);   // answers
});


</script>

</body>
</html>
