<?php

namespace App\Service;

use App\Models\Todo;
use App\Repository\TodoRepository;
use App\Traits\ImageService;
use Exception;
use Illuminate\Support\Facades\DB;

class TodoService
{
    use ImageService;

    const OPEN_STATUS = 'open';

    public function __construct(private TodoRepository $todoRepo){}

    /**
     * @throws \Exception
     */
    public function getAllAuthUserTodoLists($filterParameter,$select)
    {
        try{
            return $this->todoRepo->getAuthUserTodoListsPaginated($filterParameter,$select);
        }catch(\Exception $e){
            throw $e;
        }
    }

    public function findOrFailAuthUserTodoDetailById($id,$select=['*'])
    {
        try{
            $todoDetail = $this->todoRepo->findAuthUserTodoDetailById($id, $select);
            if (!$todoDetail) {
                throw new \Exception('Todo detail not found', 404);
            }
            return $todoDetail;
        }catch(\Exception $e){
            throw $e;
        }

    }

    public function storeTodoDetail($validatedData)
    {
        try{
            if(isset($validatedData['image'])){
                $validatedData['image'] = $this->storeImage($validatedData['image'],Todo::UPLOAD_PATH,300,300);
            }
            if(!$validatedData['status']){
                $validatedData['status'] = self::OPEN_STATUS;
            }
            return $this->todoRepo->store($validatedData);
        }catch (\Exception $e){
            throw $e;
        }

    }

    public function updateTodoDetail($todoDetail,$validatedData)
    {
        try{
            if(isset($validatedData['image'])){
                $this->removeImage(Todo::UPLOAD_PATH,$todoDetail->image);
                $validatedData['image'] = $this->storeImage($validatedData['image'],Todo::UPLOAD_PATH,300,300);
            }
            return $this->todoRepo->update($todoDetail,$validatedData);
        }catch (\Exception $e){
            throw $e;
        }
    }

    public function delete($todoDetail)
    {
        try{
            DB::beginTransaction();
            $delete = $this->todoRepo->delete($todoDetail);
            if($delete){
                $this->removeImage(Todo::UPLOAD_PATH,$todoDetail->image);
            }
            DB::commit();
            return $delete;
        }catch(Exception $exception){
            DB::rollBack();
            throw $exception;
        }
    }

    public function changeTodoStatus($todoDetail,$status)
    {
        try{
            return $this->todoRepo->updateTodoStatus($todoDetail,$status);
        }catch(Exception $exception){
            throw $exception;
        }
    }

}
