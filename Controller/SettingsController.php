<?php

namespace Kanboard\Plugin\SubtaskListDate\Controller;

use Kanboard\Controller\BaseController;

class SettingsController extends BaseController
{
    const DEFAULT_COLOR = '#d9534f';

    public function show()
    {
        $values = $this->configModel->getAll();

        if (empty($values['sld_overdue_color'])) {
            $values['sld_overdue_color'] = self::DEFAULT_COLOR;
        }

        $this->response->html($this->helper->layout->config('SubtaskListDate:config/settings', array(
            'values' => $values,
            'title'  => t('Settings').' &gt; '.t('Subtask list date'),
        )));
    }

    public function save()
    {
        $this->checkCSRFForm();
        $values = $this->request->getValues();

        $color = isset($values['sld_overdue_color']) ? $values['sld_overdue_color'] : '';

        $settings = array(
            'sld_overdue_enabled' => empty($values['sld_overdue_enabled']) ? 0 : 1,
            'sld_overdue_color'   => preg_match('/^#[0-9a-fA-F]{6}$/', $color) ? $color : self::DEFAULT_COLOR,
        );

        if ($this->configModel->save($settings)) {
            $this->flash->success(t('Settings saved successfully.'));
        } else {
            $this->flash->failure(t('Unable to save your settings.'));
        }

        $this->response->redirect($this->helper->url->to('SettingsController', 'show', array('plugin' => 'SubtaskListDate')));
    }
}
