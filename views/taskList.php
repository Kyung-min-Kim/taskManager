<!DOCTYPE html>
<html>
<head>
    <title>TODO LIST</title>
    <link rel="stylesheet" href="/public/global.css">
    <script src="/public/taskList.js" defer></script>
    <script src="/public/llmTask.js" defer></script>
</head>
<body>
<h1>TODO LIST</h1>
<form class="inputForm" method="POST">
    <select class="tagForm" name="tag" required>
        <option value="Work">Work</option>
        <option value="Personal">Personal</option>
        <option value="Exercise">Exercise</option>
    </select>
    <input id="title" type="text" name="title" placeholder="title" required>
    <input type="text" name="description" placeholder="description (optional)">  
    <button type="submit">save</button>
</form>
<div class="board">
<?php foreach ([
    'todo' => 'todo',
    'doing' => 'ongoing',
    'done' => 'completed'
] as $key => $label): ?>
  <div class="box" id="<?= $key ?>" ondrop="drop(event)" ondragover="allowDrop(event)">
  <h3 class="boxTitle">
    <span><?= $label ?></span>
    <select onchange="filterTasksByTag(this, '<?= $key ?>')">
      <option value="All">All</option>
      <option value="Work">Work</option>
      <option value="Personal">Personal</option>
      <option value="Exercise">Exercise</option>
    </select>
  </h3>
    <?php foreach ($tasks[$key] as $task): ?>
      <?php
      $classList = [];
      if ($key === 'done') $classList[] = 'done-text';
      if (!empty($task['IMPORTANT'])) $classList[] = 'important-title';
      $classAttr = implode(' ', $classList);
      ?>
      <form class="boxForm" 
            method="POST" 
            action="/?update=<?= $task['ID'] ?>" 
            draggable="true" 
            ondragstart="drag(event)" 
            id="task-<?= $task['ID'] ?>"
            data-tag="<?= htmlspecialchars($task['TAG']) ?>">
        <div class="inputBox">
            <div class="topRow">
                <button class="importantBox" formaction="/?important=<?= $task['ID'] ?>" formmethod="POST">
                    <?= ($task['IMPORTANT'] ?? 0) ? '📌' : '📍' ?>
                </button>
                <select class="tagUpdate" name="tag" required>
                    <option value="Work" <?= ($task['TAG'] ?? '') === 'Work' ? 'selected' : '' ?>>Work</option>
                    <option value="Personal" <?= ($task['TAG'] ?? '') === 'Personal' ? 'selected' : '' ?>>Personal</option>
                    <option value="Exercise" <?= ($task['TAG'] ?? '') === 'Exercise' ? 'selected' : '' ?>>Exercise</option>
                </select>
            </div>
            <input name="title" 
                   value="<?= htmlspecialchars($task['TITLE']) ?>"
                   class="<?= $classAttr ?>">
            <input name="description" 
                   value="<?= htmlspecialchars($task['DESCRIPTION']) ?>"
                   <?= $key === 'done' ? 'class="done-text"' : '' ?>>
        </div>
        <div class="buttonBox">
            <button type="submit">update</button>
            <a href="/?delete=<?= $task['ID'] ?>">delete</a>
        </div>
      </form>
    <?php endforeach; ?>
  </div>
<?php endforeach; ?>
</div>

<div class = "llmBox">
    <h1>LLM Assistance</h1>
    <form class="llmForm" id="naturalForm" onsubmit="handleNaturalInput(event)">
        <input type="text" id="naturalInput" placeholder="EX: prepare for the meeting tommorow and print the PT papers">
        <button type="submit">add</button>
    </form>
</div>

</body>
</html>
