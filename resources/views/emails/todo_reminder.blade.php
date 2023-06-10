<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reminder: Todo Due Date</title>
</head>
<body>
    <h1>Reminder: Todo Due Date</h1>
    <p>Dear {{ $todo->user->name }},</p>
    <p>This is a reminder that the due date for your Todo "{{ $todo->title }}" is approaching. The due date is {{ $todo->due_date }}.</p>
    <p>Please ensure to complete the Todo before the due date.</p>
    <p>Thank you.</p>
</body>
</html>
