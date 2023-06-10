<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Request\TodoRequest;
use App\Service\TodoService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TodoController extends Controller
{
    private $view = 'todos.';

    public function __construct(public TodoService $todoService){}

    public function index(Request $request)
    {
        try{
            $select = ['id','title','image','description','status','due_date'];
            $filterParameters = [
                'status' => $request->status ?? null
            ];
            $todoLists = $this->todoService->getAllAuthUserTodoLists($filterParameters,$select);
            return view($this->view.'index', compact(
                'filterParameters',
                'todoLists'
                )
            );
        }catch(Exception $exception){
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function create()
    {
       try{
           return view($this->view.'create');
       }catch(Exception $exception){
           return redirect()->back()->with('danger', $exception->getMessage());
       }
    }

    public function store(TodoRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $this->todoService->storeTodoDetail($validatedData);
            return redirect()
                ->route('user.todos.index')
                ->with('success', 'Todo Created Successfully');
        } catch (Exception $exception) {
            return redirect()
                ->back()
                ->with('danger', $exception->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $todoDetail = $this->todoService->findOrFailAuthUserTodoDetailById($id);
            return view($this->view.'edit',compact('todoDetail'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function update(TodoRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $todoDetail = $this->todoService->findOrFailAuthUserTodoDetailById($id);
            $this->todoService->updateTodoDetail($todoDetail,$validatedData);
            return redirect()
                ->route('user.todos.index')
                ->with('success', 'Todo Detail Updated Successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }

    public function delete($id)
    {
        try{
            $todoDetail = $this->todoService->findOrFailAuthUserTodoDetailById($id);
            $this->todoService->delete($todoDetail);
            return redirect()
                ->back()
                ->with('success', 'Todo Detail Deleted Successfully');
        }catch(Exception $exception){
            return redirect()
                ->back()
                ->with('danger', $exception->getMessage());
        }
    }

    public function changeTodoStatus(Request $request,$todoId)
    {
        try{
            $validatedData = $request->validate([
                'status' => ['required',Rule::in(array_keys(Todo::STATUS))]
            ]);
            $todoDetail = $this->todoService->findOrFailAuthUserTodoDetailById($todoId);
            $this->todoService->changeTodoStatus($todoDetail,$validatedData['status']);
            return redirect()
                ->back()
                ->with('success', 'Todo Status Changed Successfully');
        }catch(Exception $exception){
            return redirect()
                ->back()
                ->with('danger', $exception->getMessage());
        }
    }
}
