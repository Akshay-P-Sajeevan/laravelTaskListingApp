<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
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
            width: 80%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .container h1 {
            background-color: #099ffc;
            color: white;
            padding: 20px;
            text-align: center;
            margin: -20px -20px 20px;
            border-bottom: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .error {
            color: #dc3545;
            margin: 10px 0;
            padding: 10px;
            border-left: 5px solid #dc3545;
            background-color: #f8d7da;
            border-radius: 4px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="text"]:focus, textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        button:focus {
            outline: none;
        }

        ul {
            padding: 0;
            list-style: none;
        }

        ul li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Task</h1>
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="{{ $task->title }}" required>
            <label for="description">Description:</label>
            <textarea name="description" id="description">{{ $task->description }}</textarea>
            <button type="submit">Update Task</button>
        </form>
    </div>
</body>
</html>
