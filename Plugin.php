<?php

namespace Kanboard\Plugin\SubtaskListDate;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Security\Role;
use Kanboard\Core\Translator;

class Plugin extends Base
{
    public function initialize()
    {
        $this->template->setTemplateOverride('task_list/task_subtasks', 'SubtaskListDate:task_list/task_subtasks');
        $this->template->setTemplateOverride('task_list/sort_menu', 'SubtaskListDate:task_list/sort_menu');

        // Settings page (admins only)
        $this->applicationAccessMap->add('SettingsController', '*', Role::APP_ADMIN);
        $this->template->hook->attach('template:config:sidebar', 'SubtaskListDate:config/sidebar');

        // Extra sort column: earliest due date of the open subtasks of each task.
        // Evaluated lazily, because plugins are initialized in directory order and
        // SubtaskDueDate may not be loaded yet at this point.
        $this->container->extend('taskLexer', function ($taskLexer, $c) {
            $sql = $this->isSubtaskDueDatePluginLoaded()
                ? 'COALESCE((SELECT MIN(st.due_date) FROM subtasks st '
                    .'WHERE st.task_id = tasks.id AND st.status <> 2 AND st.due_date > 0), 9999999999)'
                : '9999999999';

            $taskLexer->build('')->getQuery()->subquery($sql, 'subtask_due_sort');

            return $taskLexer;
        });
    }

    public function onStartup()
    {
        $language = $this->languageModel->getCurrentLanguage();

        // Variants such as de_DE_du fall back to their base locale (de_DE)
        if (! is_dir(__DIR__.'/Locale/'.$language)) {
            $language = substr($language, 0, 5);
        }

        Translator::load($language, __DIR__.'/Locale');
    }

    private function isSubtaskDueDatePluginLoaded()
    {
        foreach ($this->container['pluginLoader']->getPlugins() as $plugin) {
            if ($plugin->getPluginName() === 'SubtaskDueDate') {
                return true;
            }
        }

        return false;
    }

    public function getPluginName()
    {
        return 'SubtaskListDate';
    }

    public function getPluginDescription()
    {
        return t('Show subtask due dates in the list view and sort tasks by them (requires SubtaskDueDate)');
    }

    public function getPluginAuthor()
    {
        return 'Nils Schmidt';
    }

    public function getPluginVersion()
    {
        return '1.1.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/nilsemann/SubtaskListDate';
    }

    public function getCompatibleVersion()
    {
        return '>=1.2.38';
    }
}
