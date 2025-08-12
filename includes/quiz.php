<?php

require_once 'Controller/Questions.php';
$ctrl = new Question();
$subjects = $ctrl->fetchAllSubjects();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Select Subject</title>
    <!-- Bootstrap & Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .card { margin-top: 50px; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .select2-container--default .select2-selection--single { height: 38px; padding: 6px 12px; }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 36px; right: 6px; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <h3 class="text-center mb-4">Choose Subject & Number of Questions</h3>
                <form method="get" action="take_test">
                    <input type="hidden" name="quiz" value="1">
                    <div class="mb-3">
                        <label class="form-label">Select Subject:</label>
                        <select class="form-select" id="subject-select" name="subject_id" required>
                            <option value="">-- Select Subject --</option>
                            <?php foreach ($subjects as $subj): ?>
                                <option value="<?= $subj->id ?>"><?= $subj->subject ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Number of Questions:</label>
                        <select class="form-select" id="limit-select" name="limit" required>
                            <option value="">-- Choose Limit --</option>
                            <?php for ($i = 5; $i <= 100; $i += 5): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Select Time (in minutes):</label>
                        <select class="form-select" id="time-select" name="time" required>
                            <option value="">-- Choose Time --</option>
                            <?php for ($i = 5; $i <= 120; $i += 5): ?>
                                <option value="<?= $i ?>"><?= $i ?> minutes</option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary w-100">Start Test</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery and Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#subject-select, #limit-select, #time-select').select2({ width: '100%' });
    });
</script>
</body>
</html>
