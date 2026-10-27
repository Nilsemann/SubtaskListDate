<?php if (! empty($task['subtasks'])): ?>
<?php
usort($task['subtasks'], function ($a, $b) {
    $da = empty($a['due_date']) ? PHP_INT_MAX : (int) $a['due_date'];
    $db = empty($b['due_date']) ? PHP_INT_MAX : (int) $b['due_date'];
    return $da <=> $db;
});
$overdueColor = '';
if ($this->app->config('sld_overdue_enabled') == 1) {
    $color = $this->app->config('sld_overdue_color', '#d9534f');
    $overdueColor = preg_match('/^#[0-9a-fA-F]{6}$/', $color) ? $color : '#d9534f';
}
$today = strtotime('today');
?>
<div class="task-list-subtasks">
    <?php foreach ($task['subtasks'] as $subtask): ?>
        <div class="task-list-subtask">
            <span class="subtask-cell column-40">
                <?= $this->subtask->renderToggleStatus($task, $subtask, 'rows', isset($user_id) ? $user_id : 0) ?>
            </span>
            <span class="subtask-cell column-20 subtask-assignee">
                <?php if (! empty($subtask['username'])): ?>
                    <?= $this->text->e($subtask['name'] ?: $subtask['username']) ?>
                <?php endif ?>
            </span>
            <span class="subtask-cell column-15 subtask-due-date">
                <?php if (! empty($subtask['due_date'])): ?>
                    <?php $isOverdue = $overdueColor !== '' && $subtask['status'] != 2 && $subtask['due_date'] < $today ?>
                    <span<?= $isOverdue ? ' style="color: '.$overdueColor.'; font-weight: bold"' : '' ?>>
                        <i class="fa fa-calendar"></i>
                        <?= $this->dt->date($subtask['due_date']) ?>
                    </span>
                <?php endif ?>
            </span>
            <span class="subtask-cell subtask-time-tracking-cell">
                <?= $this->render('subtask/timer', array(
                    'task'    => $task,
                    'subtask' => $subtask,
                )) ?>
            </span>
        </div>
    <?php endforeach ?>
</div>
<?php endif ?>
