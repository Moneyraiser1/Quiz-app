<?php
include '../inc/header.php';
$classes = ['JSS1', 'JSS2', 'JSS3', 'SS1', 'SS2', 'SS3'];
$ssSubjects = ['Biology', 'Mathematics', 'Chemistry', 'Physics', 'Government', 'Literature'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Select Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            margin-top: 50px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <h3 class="text-center mb-4">Choose Your Class and Subject</h3>
                <form method="get" action="take_test.php">
                    <div class="mb-3">
                        <label for="class" class="form-label">Select Class:</label>
                        <select class="form-select" name="class" id="class" required>
                            <option value="">-- Select Class --</option>
                            <?php foreach ($classes as $class): ?>
                                <option value="<?= $class ?>"><?= $class ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">Select Subject:</label>
                        <select class="form-select" name="subject" id="subject" required>
                            <option value="">-- Select Subject --</option>
                        </select>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100">Start Test</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const jssSubjects = <?= json_encode($jssSubjects) ?>;
    const ssSubjects = <?= json_encode($ssSubjects) ?>;

    $('#class').on('change', function () {
        const selectedClass = $(this).val();
        const subjectSelect = $('#subject');
        subjectSelect.empty();
        subjectSelect.append('<option value="">-- Select Subject --</option>');

        let subjects = [];

        if (selectedClass.startsWith('JSS')) {
            subjects = jssSubjects;
        } else if (selectedClass.startsWith('SS')) {
            subjects = ssSubjects;
        }

        subjects.forEach(function (subj) {
            subjectSelect.append('<option value="' + subj + '">' + subj + '</option>');
        });
    });
</script>
</body>
</html>
<?php require '../inc/footer.php'; ?>