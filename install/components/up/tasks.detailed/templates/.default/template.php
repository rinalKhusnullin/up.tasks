<?php 

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$task = $arResult['task'];

?>


<section class="hero is-primary">
    <div class="hero-body">
        <p class="title">
            <?= $task['TITLE']; ?>
        </p>
    </div>
</section>
<article class="panel is-primary">
    <p class="panel-tabs is-large pl-3 has-text-weight-semibold is-size-5 is-bordered">
        <a class="is-active">Task</a>
        <a>Settings</a>
    </p>
    <div id="Task" class="panel-block container is-flex-direction-column">
        <div class="columns">
            <div class="column is-two-thirds">
                <article class="message is-warning is-medium">
                    <div class="message-header">
                        <p>What to do</p>
                    </div>
                    <div class="message-body">
                        <?= $task['DESCRIPTION'] ?>
                    </div>
                </article>
                <?php foreach ($task['COMMENTS'] as $key => $comment) : ?>
                <article class="message">
                    <div class="message-header">
                        <p>Comment #<?= $key + 1 ?></p>
                        <button class="delete" aria-label="delete"></button>
                    </div>
                    <div class="message-body">
                        <?= $comment['COMMENT'] ?>
                    </div>
                </article>
                <?php endforeach; ?>

                <article class="media">
                    <div class="media-content">
                        <div class="field">
                            <p class="control">
                                <textarea class="textarea" placeholder="Add a comment..."></textarea>
                            </p>
                        </div>
                        <div class="field">
                            <p class="control">
                                <button class="button" disabled>TO COMMENT</button>
                            </p>
                        </div>
                    </div>
                </article>
            </div>
            <div class="column">
                <div class="card">
                    <header class="card-header has-background-warning">
                        <p class="card-header-title has-text-black">
                            Metadata
                        </p>
                        <button class="card-header-icon" aria-label="more options">
                            <span class="icon">
                                <i class="fas fa-angle-down" aria-hidden="true"></i>
                            </span>
                        </button>
                    </header>
                    <div class="card-content px-2 py-2">
                        <table class="table is-hoverable is-fullwidth">
                            <tr>
                                <td><strong>Date creating</strong></td>
                                <td><?=$task['METADATA_CREATING_DATE']?></td>
                            </tr>
                            <tr>
                                <td><strong>Date updating</strong></td>
                                <td><?=$task['METADATA_UPDATING_DATE']?></td>
                            </tr>
                            <tr>
                                <td><strong>Last Activity</strong></td>
                                <td><?=$task['METADATA_LAST_ACTIVITY']?></td>
                            </tr>
                            <tr>
                                <td><strong>Deadline</strong></td>
                                <td><?=$task['METADATA_DEADLINE']?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="Settings" class="panel-block container is-flex-direction-column is-align-items-stretch hidden">
        <form action="./" method="post">
            <div class="field">
                <label class="label">Title</label>
                <div class="control">
                    <input class="input" type="text" placeholder="New task title" name="title" value="<?=$task['TITLE']?>">
                </div>
                <!-- <p class="help is-success">This project title is available</p> -->
            </div>
            <div class="field">
                <label class="label">What to do</label>
                <div class="control">
                    <textarea class="textarea" placeholder="e.g. Hello world" name="description"><?=$task['DESCRIPTION']?></textarea>
                </div>
            </div>
            <div class="field">
                <label class="label">Deadline</label>
                <div class="control">
                    <input type="datetime-local" id="deadline" name="deadline" value="<?=$task['DEADLINE_HTML_FORMAT']?>"
                        min="<?=(new Datetime())->format('Y-m-d')?>">
                </div>
            </div>
            <div class="field is-grouped">
                <div class="control project-settings-btns">
                    <button type="submit" class="button is-success">Submit</button>
                </div>
            </div>
        </form>
    </div>
</article>
