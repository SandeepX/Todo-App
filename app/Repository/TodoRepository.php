<?php

namespace App\Repository;

use App\Helper\AppHelper;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;

class TodoRepository
{
    const STATUS_COMPLETE = 'complete';

    public function getAuthUserTodoListsPaginated($filterParameters, $select = ['*'])
    {
        return Todo::select($select)
            ->when(isset($filterParameters['status']), function ($query) use ($filterParameters) {
                $query->where('status', $filterParameters['status']);
            })
            ->latest()
            ->where('user_id', AppHelper::getAuthUserId())
            ->paginate(Todo::RECORD_PER_PAGE);
    }

    public function findAuthUserTodoDetailById($id, $select = ['*'])
    {
        return Todo::select($select)
            ->where('id', $id)
            ->where('user_id', AppHelper::getAuthUserId())
            ->first();
    }

    public function store($validatedData)
    {
        return Todo::create($validatedData)->fresh();
    }

    public function updateTodoStatus($todoDetail, $status)
    {
        return $todoDetail->update([
            'status' => $status
        ]);

    }

    public function update($todoDetail, $validatedData)
    {
        $todoDetail->update($validatedData);
        return $todoDetail->fresh();
    }

    public function delete($todoDetail)
    {
        return $todoDetail->delete();
    }

    public function getAllNotCompletedTodoListOneDayBeforeTheDeadline(): Collection|array
    {
        return Todo::with('user')
            ->where('status', '!=', self::STATUS_COMPLETE)
            ->whereDate('due_date', now()->addDay())
            ->get();
    }

}
