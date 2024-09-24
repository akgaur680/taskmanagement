<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epic Task View Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .task-container {
            border: 2px solid black;
            padding: 20px;
        }
        .task-header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .task-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .task-meta {
            width: 35%;
        }
        .task-meta div {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid black;
            text-align: center;
            font-weight: bold;
        }
        .task-description {
            width: 55%;
            border: 1px solid black;
            padding: 15px;
            text-align: center;
            font-weight: bold;
        }
        .subtask-table {
            border: 1px solid black;
            padding: 20px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5 task-container">
        <div class="task-header">
            Epic Task View Page
        </div>
        <div class="task-details">
            <div class="task-meta">
                <div>Title : {{$task['title']}}</div>
                <div>Deadline : {{$task['deadline']}}</div>
                <div>Status : {{$task['status']['status']}}</div>
            </div>
            <div class="task-description">
                <h5>Description</h5>
                <p>{{$task['description']}}</p>
            </div>
        </div>
        <div class="subtask-table">
            <h3>Subtask Table</h3>
            <table class="table table-bordered">
                <caption class="caption-top">Recurring Task</caption>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Recurring Days</th>
                </tr>
                @foreach ($subtasks as $subtask)
                @if ($subtask['task_type_id'] == 2) <!-- Corrected the condition -->
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $subtask['title'] }}</td>
                    <td>{{ $subtask['status']['status'] }}</td>
                    <td>{{ $subtask['days'] }}</td>
                </tr>
                @endif
                @endforeach
            </table>
        </div>
        <div class="subtask-table">
            <table class="table table-bordered">
                <caption class="caption-top">OneTime Task</caption>
                <tr>
                    <!-- <th>#</th> -->
                    <th>Title</th>
                    <th>Status</th>
                    <th>Deadline</th>
                </tr>
                @foreach ($subtasks as $subtask)
                @if ($subtask['task_type_id'] == 1) <!-- Corrected the condition -->
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $subtask['title'] }}</td>
                    <td>{{ $subtask['status']['status'] }}</td>
                    <td>{{ $subtask['deadline'] }}</td>
                </tr>
                @endif
                @endforeach
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>