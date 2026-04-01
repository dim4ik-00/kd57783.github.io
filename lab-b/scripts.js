class Todo {
  constructor() {
    this.tasks = JSON.parse(localStorage.getItem('todoTasks')) || [];
    this.term = "";

    this.listElement = document.getElementById('todoList');
    this.searchInput = document.getElementById('searchInput');
    this.taskInput = document.getElementById('taskInput');
    this.dateInput = document.getElementById('dateInput');
    this.addBtn = document.getElementById('addBtn');

    this.init();
  }

  init() {
    this.addBtn.addEventListener('click', () => this.add());

    this.searchInput.addEventListener('input', (e) => {
      this.term = e.target.value;
      this.draw();
    });

    this.draw();
  }

  add() {
    const text = this.taskInput.value.trim();
    const date = this.dateInput.value;
    const now = new Date().toISOString().split('T')[0];

    if (text.length < 3 || text.length > 255) {
      alert("Tekst: 3-255 znaków.");
      return;
    }
    if (date !== "" && date < now) {
      alert("Data nie może być z przeszłości.");
      return;
    }

    this.tasks.push({
      id: Date.now(),
      text: text,
      date: date
    });

    this.save();
    this.taskInput.value = "";
    this.dateInput.value = "";
    this.draw();
  }

  remove(id) {
    this.tasks = this.tasks.filter(t => t.id !== id);
    this.save();
    this.draw();
  }

  save() {
    localStorage.setItem('todoTasks', JSON.stringify(this.tasks));
  }

  getFilteredTasks() {
    if (this.term.length < 2) return this.tasks;
    return this.tasks.filter(t =>
      t.text.toLowerCase().includes(this.term.toLowerCase())
    );
  }

  draw() {
    this.listElement.innerHTML = "";
    const filtered = this.getFilteredTasks();

    filtered.forEach(task => {
      const item = document.createElement('div');
      item.className = 'todo-item';

      // Podświetlanie frazy w tekście [cite: 38, 92]
      let highlightedText = task.text;
      if (this.term.length >= 2) {
        const regex = new RegExp(`(${this.term})`, 'gi');
        highlightedText = task.text.replace(regex, '<mark>$1</mark>');
      }

      item.innerHTML = `
                <input type="checkbox">
                <div class="task-view-mode" style="flex: 1; display: flex; align-items: center;">
                    <span class="task-text" style="flex: 1; margin-left: 10px;">${highlightedText}</span>
                    <span class="task-date" style="font-weight: bold; margin: 0 20px;">${task.date}</span>
                </div>
                <button class="delete-btn" onclick="document.todo.remove(${task.id})">🗑️</button>
            `;

      const viewMode = item.querySelector('.task-view-mode');
      viewMode.onclick = (e) => {
        if (e.target.tagName !== 'INPUT') this.enterEditMode(item, task);
      };

      this.listElement.appendChild(item);
    });
  }

  enterEditMode(itemElement, task) {
    itemElement.innerHTML = `
            <input type="checkbox">
            <input type="text" class="edit-text" value="${task.text}" style="flex: 1; margin: 0 5px;">
            <input type="date" class="edit-date" value="${task.date}" style="width: 130px;">
            <button class="save-edit-btn">Zapisz</button>
            <button class="delete-btn" disabled>🗑️</button>
        `;

    const textInput = itemElement.querySelector('.edit-text');
    const dateInput = itemElement.querySelector('.edit-date');
    const saveBtn = itemElement.querySelector('.save-edit-btn');

    const saveChanges = () => {
      task.text = textInput.value;
      task.date = dateInput.value;
      this.save();
      this.draw();
    };

    saveBtn.onclick = (e) => {
      e.stopPropagation();
      saveChanges();
    };

    textInput.onblur = (e) => {
      if (!itemElement.contains(e.relatedTarget)) {
        setTimeout(() => saveChanges(), 100);
      }
    };

    textInput.focus();
  }
}

document.addEventListener('DOMContentLoaded', () => {
  document.todo = new Todo();
});
