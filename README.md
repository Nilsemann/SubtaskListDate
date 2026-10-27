# SubtaskListDate

A [Kanboard](https://kanboard.org) plugin that brings subtask due dates into the **project list view**.

The [SubtaskDueDate](https://github.com/eSkiSo/Subtaskdate) plugin lets you set a due date on subtasks, but shows it only in the task details, the dashboard and the board tooltip. SubtaskListDate adds it to the list view as well:

- **Due date column** for every subtask in the list view
- **Subtasks sorted by due date** within each task (subtasks without a date come last)
- **New sort option** *Sort → Subtask due date*: tasks are ordered by the earliest due date of their open subtasks. Tasks without such a date come last, completed subtasks are ignored.
- **Optional highlighting of overdue subtasks** in a color of your choice (admin setting)

<!-- Add screenshots here, e.g. ![List view](docs/list-view.png) -->

## Requirements

- Kanboard **1.2.38** or newer (developed and tested against 1.2.38)
- The [SubtaskDueDate](https://github.com/eSkiSo/Subtaskdate) plugin, which provides the subtask `due_date` field. Without it SubtaskListDate shows no dates, but the list view keeps working.

## Installation

1. Download this repository (or a release) and place it in the Kanboard plugin directory. The folder **must be named** `SubtaskListDate`:
   ```
   kanboard/plugins/SubtaskListDate/
   ```
2. Make sure the web server user can read the files.
3. Reload Kanboard. The plugin is picked up automatically (check *Settings → Plugins*).

## Configuration

*Settings → Subtask list date* (administrators only):

| Setting | Description | Default |
|---|---|---|
| Highlight overdue subtasks | Show open subtasks whose due date is before today in a different color | off |
| Color for overdue subtasks | Color of the date, chosen with a color picker | `#d9534f` |

A subtask counts as overdue if it is not completed and its due date lies before today.

## How it works

The plugin overrides two core list view templates (`task_list/task_subtasks` and `task_list/sort_menu`). It adds the computed column `subtask_due_sort` to the task query used by the list view. If another plugin overrides the same templates, only one of them wins.

## Translations

Texts live in `Locale/<language>/translations.php`, keyed by their English text. Included: `de_DE`. English needs no file. Pull requests with further languages are welcome: copy `Locale/de_DE/translations.php` and translate the values.

## Compatibility notes

- Tested only with Kanboard 1.2.38. Other versions may differ in the list view templates.
- The sort option sorts only the main tasks in the list; the order of subtasks within a task is always by due date.

## License

[MIT](LICENSE). The overridden templates are derived from Kanboard, © Frédéric Guillot.

---

## Deutsch

Zeigt die Fälligkeit von Teilaufgaben (aus dem Plugin [SubtaskDueDate](https://github.com/eSkiSo/Subtaskdate)) in der **Listenansicht** eines Projekts an.

- Spalte mit dem Fälligkeitsdatum je Teilaufgabe
- Teilaufgaben innerhalb einer Aufgabe nach Fälligkeit sortiert
- Neuer Menüpunkt *Sortieren → Fälligkeit Teilaufgabe* (früheste offene Teilaufgabe bestimmt die Reihenfolge der Aufgaben)
- Optional: überfällige Teilaufgaben in frei wählbarer Farbe hervorheben (*Einstellungen → Teilaufgaben-Fälligkeit (Liste)*, nur Admins)

**Installation:** Ordner als `plugins/SubtaskListDate` ablegen (Name muss genau so lauten), Dateirechte für den Webserver-Benutzer prüfen und Kanboard neu laden. Voraussetzung: Kanboard ≥ 1.2.38 und das Plugin SubtaskDueDate.
