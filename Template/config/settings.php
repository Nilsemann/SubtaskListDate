<div class="page-header">
    <h2><?= t('Subtask list date') ?></h2>
</div>
<form method="post" action="<?= $this->url->href('SettingsController', 'save', array('plugin' => 'SubtaskListDate')) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>

    <?= $this->form->checkbox('sld_overdue_enabled', t('Highlight overdue subtasks'), 1, isset($values['sld_overdue_enabled']) && $values['sld_overdue_enabled'] == 1) ?>
    <p class="form-help"><?= t('Open subtasks whose due date is before today are shown in the color below.') ?></p>

    <?= $this->form->label(t('Color for overdue subtasks'), 'sld_overdue_color') ?>
    <?= $this->form->input('color', 'sld_overdue_color', $values, $errors) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-blue"><?= t('Save') ?></button>
    </div>
</form>
