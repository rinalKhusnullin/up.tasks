<?php

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Request;
use Up\Tasks\Task\Repository;

class TaskDetailsComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        Loader::includeModule('up.tasks');

        $request = Application::getInstance()->getContext()->getRequest();
        $taskId = $request->get('taskId');

        if ($request->getRequestMethod() === 'POST') $this->updateTask($taskId, $request);

        $this->getTask($taskId);

        if (empty($this->arResult['task']))
        {
            $this->includeComponentTemplate('task-not-found');
        }
        else
        {
            $this->includeComponentTemplate();
        }
    }

    protected function prepareDateFields($task)
    {
        if (empty($task)) return null;
        
        $task['METADATA_CREATING_DATE'] = $task['METADATA_CREATING_DATE']->format('d M Y - H:i');
        
        $task['METADATA_UPDATING_DATE'] = $task['METADATA_UPDATING_DATE']->format('d M Y - H:i');

        $task['DEADLINE_HTML_FORMAT'] = $task['METADATA_DEADLINE']->format('Y-m-d\TH:i:s');
        
        $task['METADATA_DEADLINE'] = $task['METADATA_DEADLINE']->format('d M Y - H:i');

        if (isset($task['METADATA_LAST_ACTIVITY']))
        {
            $task['METADATA_LAST_ACTIVITY'] = $task['METADATA_LAST_ACTIVITY']->format('d M Y - H:i');
        }
        else
        {
            $task['METADATA_LAST_ACTIVITY'] = 'not commented';
        }

        return $task;
    }

    protected function getTask(int $taskId)
    {
        $task = Repository::getTask($taskId);
        $task = $this->prepareDateFields($task);
        $this->arResult['task'] = $task;
    }

    protected function updateTask(int $taskId, Request $request)
    {
        $title = $request->get('title');
        
        $description = $request->get('description');

        $deadline = $request->get('deadline');
        $deadline = str_replace('T', ' ', $deadline);

        Repository::updateTask($taskId, $title, $description, $deadline);
    }
}