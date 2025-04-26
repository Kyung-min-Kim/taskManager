function allowDrop(e) {
  e.preventDefault();
}

function drag(e) {
  e.dataTransfer.setData("text", e.target.id);
}

function drop(e) {
  e.preventDefault();
  const taskId = e.dataTransfer.getData("text").replace("task-", "");
  const newStatus = e.currentTarget.id;

  fetch("/updateStatus.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({ id: taskId, status: newStatus }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) location.reload();
      else alert("ERROR");
    });
}

function filterTasksByTag(selectElement, boxId) {
  const selectedTag = selectElement.value;
  const box = document.getElementById(boxId);
  const tasks = box.querySelectorAll(".boxForm");

  tasks.forEach((task) => {
    const taskTag = task.getAttribute("data-tag");
    if (selectedTag === "All" || taskTag === selectedTag) {
      task.style.display = "";
    } else {
      task.style.display = "none";
    }
  });
}
