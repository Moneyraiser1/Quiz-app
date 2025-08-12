<?php
require_once "leaderboardController/LeaderBoard.php";
$leaderboard = new LeaderBoard();

$subjects = $leaderboard->fetchAllSubjects();
$subject_id = isset($_GET['subject_id']) ? (int)$_GET['subject_id'] : null;
$results = $leaderboard->getLeaderboard($subject_id);
?>

<div class="container mt-4">
    <h3 class="mb-4">Leaderboard</h3>

    <form method="get" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <label for="subject" class="col-form-label">Filter by Subject:</label>
            </div>
            <div class="col-auto">
                <select name="subject_id" id="subject" class="form-select">
                    <option value="">All Subjects</option>
                    <?php foreach ($subjects as $sub): ?>
                        <option value="<?= $sub->id ?>" <?= ($subject_id == $sub->id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($sub->subject) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <?php if ($subject_id && is_array($results) && count($results)): ?>
        <!-- Subject-specific leaderboard -->
        <h5 class="bg-info text-white p-2">Subject Leaderboard</h5>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Student</th>
                    <th>Score</th>
                    <th>Total</th>
                    <th>Percentage</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php $rank = 1; foreach ($results as $row): ?>
                    <tr>
                        <td><?= $rank++ ?></td>
                        <td><?= htmlspecialchars($row->student_name) ?></td>
                        <td><?= $row->score ?></td>
                        <td><?= $row->total ?></td>
                        <td><?= round($row->percentage, 2) ?>%</td>
                        <td><?= date('Y-m-d', strtotime($row->taken_at)) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php elseif (!$subject_id && is_array($results) && count($results)): ?>
        <!-- Overall leaderboard (grouped) -->
        <h5 class="bg-info text-white p-2">Overall Mean Percentage Leaderboard</h5>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Student</th>
                    <th>Mean Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $averages = [];

                // Compute mean per student
                foreach ($results as $subject => $rows) {
                    foreach ($rows as $r) {
                        $averages[$r->student_name][] = $r->percentage;
                    }
                }

                // Sort by mean percentage
                $means = [];
                foreach ($averages as $student => $percentages) {
                    $mean = array_sum($percentages) / count($percentages);
                    $means[] = ['student' => $student, 'mean' => $mean];
                }
                usort($means, fn($a, $b) => $b['mean'] <=> $a['mean']);

                $rank = 1;
                foreach ($means as $row):
                ?>
                    <tr>
                        <td><?= $rank++ ?></td>
                        <td><?= htmlspecialchars($row['student']) ?></td>
                        <td><?= round($row['mean'], 2) ?>%</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>
        <div class="alert alert-warning">No results found.</div>
    <?php endif; ?>
</div>
