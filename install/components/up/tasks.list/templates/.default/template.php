<?php

    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
    \Bitrix\Main\UI\Extension::load('up.tasks-list');
?>

<nav class="level">
    <!-- Left side -->
    <div class="level-left">
        <div class="level-item">
            <a class="button is-link open-popup" >
                Создать задачу 
            </a>
        </div>
    </div>

    <!-- Right side -->
    <div class="level-right">
        <p class="level-item"><a class="button" href="/">All</a></p>
        <p class="level-item"><a class="button is-danger" title="not working yet">Невыполненные</a></p>
        <p class="level-item"><a class="button is-success" title="not working yet">Выполненные</a></p>
    </div>
</nav>

<div id="task-container"></div>

<div class="popup__bg"> 
    <div class="popup" id="createTaskPanel">
        <i class="fa fa-times-circle close-popup" aria-hidden="true"></i>
        <label>
            <input type="text" name="title" id="title">
            <div class="label__text">
                Название задачи
            </div>
        </label>
        <label>
            <textarea type="text" name="description" id="description"></textarea>
            <div class="label__text">
                Описание задачи
            </div>
        </label>
        <label>
            <input type="datetime-local" name="deadline" id="deadline">
            <div class="label__text">
                Дедлайн
            </div>
        </label>
        <button onclick="createTask(); return false;">Отправить</button>
    </div>
</div> 

<script>
    BX.ready(function (){
        window.TasksList = new BX.Up.Tasks.TasksList({
            rootNodeId: 'task-container',
        });
    });
    
    function completeTask(taskId)
    {
        window.TasksList.completeTask(taskId);
    }

    function deleteTask(taskId)
    {
        window.TasksList.deleteTask(taskId);
    }

    function unCompleteTask(taskId)
    {
        window.TasksList.unCompleteTask(taskId);
    }

    function createTask()
    {
        let title = BX('title').value;
        let description = BX('description').value;
        let deadline = BX('deadline').value;
        window.TasksList.createTask(title, description, deadline);
    }

    function closeCreatingTaskPanel(){
        BX('title').value = '';
        BX('description').value = '';
        BX('deadline').value = '';

        let popupBg = document.querySelector('.popup__bg'); 
        let popup = document.querySelector('.popup');
        popupBg.classList.remove('active');
        popup.classList.remove('active');
    }
</script>