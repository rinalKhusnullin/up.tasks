<?php 

namespace Up\Tasks\Task;

use Bitrix\Main\ORM\Fields\ExpressionField;
use Bitrix\Main\Type;
use Up\Tasks\Model\CommentTable;
use Up\Tasks\Model\MetadataTable;
use Up\Tasks\Model\TaskTable;

class Repository
{
    public static function getTasksList()
    {

        $tasks = TaskTable::getList([
            'select' => ['ID', 'TITLE', 'DESCRIPTION', 'IS_COMPLETED', 'DEADLINE' => 'METADATA.DEADLINE'],
        ])->fetchAll();

        return $tasks;
    }

    public static function deleteTask(int $taskId) : array
    {

        $errors = [];
        // Удаление комментариев у задачи
        $commentsId = CommentTable::getList([
            'select' => ['ID'],
            'filter' => ['=ID_TASK' => $taskId],
        ])->fetchAll();

        foreach($commentsId as $commentId)
        {
            $isCommentDeleted = CommentTable::delete($commentId['ID']);

            if (!$isCommentDeleted->isSuccess())
            {
                $errors[] = $isCommentDeleted->getErrorMessages();
            }
        }

        $isMetadataDeleted = MetadataTable::delete($taskId);

        if (!$isMetadataDeleted->isSuccess())
        {
            $errors[] = $isMetadataDeleted->getErrorMessages();
        }

        $isTaskDeleted = TaskTable::delete($taskId);

        if (!$isTaskDeleted->isSuccess())
        {
            $errors[] = $isTaskDeleted->getErrorMessages();
        }

        return $errors;
    }

    public static function completeTask(int $taskId) : array
    {
        $errors = [];

        $isMetadataUpdate = MetadataTable::update($taskId, [
            'UPDATING_DATE' => new Type\DateTime(date('Y-m-d H:i:s'), 'Y-m-d H:i:s'),
        ]);

        $isTaskComplete = TaskTable::update($taskId, [
            'IS_COMPLETED' => 1,
        ]);

        if (!$isTaskComplete->isSuccess())
        {
            $errors[] = $isTaskComplete->getErrorMessages();
        }

        return $errors;
    }

    public static function unCompleteTask(int $taskId) : array
    {
        $errors = []; 

        $isMetadataUpdate = MetadataTable::update($taskId, [
            'UPDATING_DATE' => new Type\DateTime(date('Y-m-d H:i:s'), 'Y-m-d H:i:s'),
        ]);

        if (!$isMetadataUpdate->isSuccess())
        {
            $errors[] = $isMetadataUpdate->getErrorMessages();
        }

        $isTaskUnComplete = TaskTable::update($taskId, [
            'IS_COMPLETED' => 0,
        ]);

        if (!$isTaskUnComplete->isSuccess())
        {
            $errors[] = $isTaskUnComplete->getErrorMessages();
        }

        return $errors;
    }

    public static function getTasksCount()
    {
        return TaskTable::getList([
            'select' => [
                'runtime' => new ExpressionField('TASKS_COUNT', 'COUNT(%s)', ['ID']),
            ]
        ])->fetch()['runtime'];
    }

    public static function createTask(string $title, string $description, $deadline)
    {
        $errors = [];
         
        $isCreatedTask = TaskTable::add([
            'TITLE' => $title,
            'DESCRIPTION' => $description,
            'IS_COMPLETED' => 0,
            'ID_PRIORITY' => 1,
        ]);

        if (!$isCreatedTask->isSuccess())
        {
            $errors[] = $isCreatedTask->getErrorMessages();
        }

        $isCreatedMetadata = MetadataTable::add([
            'ID_TASK' => $isCreatedTask->getId(),
            'DEADLINE' => new Type\DateTime($deadline, 'Y-m-d H:i:s'),
            'CREATING_DATE' => new Type\DateTime(),
            'UPDATING_DATE' => new Type\DateTime(),
            'LAST_ACTIVITY' => null
        ]);

        if (!$isCreatedMetadata->isSuccess())
        {
            $errors[] = $isCreatedMetadata->getErrorMessages();
        }

        return $errors;
    }

    public static function getTask(int $taskId)
    {
        $task = TaskTable::getList([
            'select' => ['ID', 'TITLE', 'DESCRIPTION', 'IS_COMPLETED', 'METADATA_' => 'METADATA'],
            'filter' => ['=ID' => $taskId]
        ])->fetch();

        $comments = CommentTable::getList([
            'select' => ['COMMENT'],
            'filter' => ['=ID_TASK' => $taskId],
        ])->fetchAll();

        if (!empty($comments)) $task['COMMENTS'] = $comments;
       
        return $task;
    }

    public static function updateTask(int $taskId, string $title, string $description, string $deadline)
    {
        TaskTable::update($taskId, [
            'TITLE' => $title,
            'DESCRIPTION' => $description
        ]);

        MetadataTable::update($taskId, [
            'UPDATING_DATE' => new Type\DateTime(date('Y-m-d H:i:s'), 'Y-m-d H:i:s'),
            'DEADLINE' => new Type\DateTime($deadline, 'Y-m-d H:i:s'),
        ]);

        return true;
    }
}