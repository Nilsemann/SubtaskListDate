<li <?= $this->app->checkMenuSelection('SettingsController', 'show') ?>>
    <?= $this->url->link(t('Subtask list date'), 'SettingsController', 'show', array('plugin' => 'SubtaskListDate')) ?>
</li>
