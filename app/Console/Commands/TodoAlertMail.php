<?php

namespace App\Console\Commands;

use App\Mail\TodoMail;
use App\Repository\TodoRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TodoAlertMail extends Command
{

    protected TodoRepository $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        parent::__construct();
        $this->todoRepository = $todoRepository;
    }

    protected $signature = 'send:todo-alert-mail';


    protected $description = 'Send Mail notification to all users when deadline is one day away from now';


    public function handle()
    {
        $todos = $this->todoRepository->getAllNotCompletedTodoListOneDayBeforeTheDeadline();

        if (count($todos) === 0) {
            $this->info('No Todo Records Available to Send Reminder Email');
            return;
        }

        foreach ($todos as $todo) {
            $userEmail = $todo->user?->email ?? null;
            if ($userEmail) {
                Mail::to($userEmail)->send(new TodoMail($todo));
            }
        }

        $this->info('Todo Reminder Email Sent Successfully!');

    }
}
