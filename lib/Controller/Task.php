<?php

namespace Up\Tasks\Controller;

use Bitrix\Main\Engine\Controller;
use Up\Tasks\Task\Repository;
use Bitrix\Main\Error;

class Task extends Controller
{
    protected const TASKS_PER_PAGE = 3;

    public function getTasksListAction() : array
    {

        $tasksList = Repository::getTasksList();

        return [
            'tasksList' => $tasksList,
        ];
    }

    public function deleteTaskAction(int $taskId) : ?bool
    {
        if ($taskId < 0)
		{
			$this->addError(new Error('taskId should be greater than 0', 'invalid_task_id'));

			return null;
		}

        $isTaskDeletedErrors = Repository::deleteTask($taskId);

        if (empty($isTaskDeletedErrors))
        {
            return true;
        }
        else
        {
            $this->addErrors($isTaskDeletedErrors);

            return null;
        }
    }

    public function completeTaskAction(int $taskId) : ?bool
    {
        if ($taskId < 0)
		{
			$this->addError(new Error('taskId should be greater than 0', 'invalid_task_id'));

			return null;
		}

        $isTaskCompletedErrors = Repository::completeTask($taskId);

        if (empty($isTaskCompletedErrors))
        {
            return true;
        }
        else
        {
            $this->addErrors($isTaskCompletedErrors);

            return null;
        }
    }

    public function unCompleteTaskAction(int $taskId) : ?bool
    {
        if ($taskId < 0)
		{
			$this->addError(new Error('taskId should be greater than 0', 'invalid_task_id'));

			return null;
		}

        $isTaskCompletedErrors = Repository::unCompleteTask($taskId);

        if (empty($isTaskCompletedErrors))
        {
            return true;
        }
        else
        {
            $this->addErrors($isTaskCompletedErrors);

            return null;
        }
    }

    public function getTasksCountAction()
    {
        $tasksCount = Repository::getTasksCount();
        return [
            'tasksCount' => $tasksCount,
        ];
    }

    public function createTaskAction(string $title, string $description, string $deadline)
    {
        if (mb_strlen(trim($title)) <= 0) 
        {
			$this->addError(new Error('Task title cannot be null', 'invalid_task_title'));
			return null;
		}

        if (mb_strlen(trim($description)) <= 0)
        {
			$this->addError(new Error('Task description cannot be null', 'invalid_task_description'));
			return null;
		} 

        $deadline = str_replace('T', ' ', $deadline);

        $isCreatedTaskErrors = Repository::createTask($title, $description, $deadline);

        if (empty($isCreatedTaskErrors))
        {
            return true;
        }
        else
        {
            $this->addErrors($isCreatedTaskErrors);

            return null;
        }
    }
}