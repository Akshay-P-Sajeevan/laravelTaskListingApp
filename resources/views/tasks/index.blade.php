<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        .container {
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            width: 90%;
            max-width: 1000px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .container h1 {
            background-color: #000080;
            color: white;
            padding: 20px;
            text-align: center;
            margin: 0 0 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin-right: 10px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .success {
            color: #155724;
            margin: 10px 0;
            padding: 10px;
            border-left: 5px solid #28a745;
            background-color: #d4edda;
            border-radius: 4px;
            display: none;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #ffffff;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color:  #099ffc;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        button.delete-button {
            background-color: #dc3545;
        }

        button.delete-button:hover {
            background-color: #c82333;
        }

        button:focus {
            outline: 2px solid #0056b3;
            outline-offset: 2px;
        }

        form {
            display: inline;
        }

        .task-actions {
            display: flex;
            gap: 10px;
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }

            .btn, button {
                padding: 8px 12px;
                font-size: 14px;
            }

            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>To-Do List</h1>
        <a href="{{ route('tasks.create') }}" class="btn">Add Task</a>
        @if (session('success'))
            <div id="success-message" class="success">{{ session('success') }}</div>
        @endif
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Creation Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td><strong>{{ $task->title }}</strong></td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->status }}</td>
                        <td>{{ $task->created_at->format('Y-m-d') }}</td>
                        <td class="task-actions">
                            <form action="{{ route('tasks.edit', $task) }}" method="GET">
                                <button type="submit">Edit</button>
                            </form>
                            @if ($task->status !== 'completed')
                                <form action="{{ route('tasks.updateStatus', $task) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit">Completed</button>
                                </form>
                            @endif
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
           
            var successMessage = document.getElementById('success-message');

            
            if (successMessage) {
                
                successMessage.style.display = 'block';

                
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 1500);
            }
        });
    </script>
</body>
</html>
