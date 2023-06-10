@extends('layouts.app')

@section('content')

    <div class="container">
        @include('layouts.flash_message')


        <div class="search-box p-4  bg-white rounded mb-3 box-shadow pb-2">
            <form class="forms-sample" action="{{route('user.todos.index')}}" method="get">
                <h5 class="mb-3 text-primary">Todo  Filter</h5>
                <div class="row align-items-center">
                    <div class="col-xxl col-xl-4  col-md-6 mb-3">
                        <label for="" class="form-label">Status</label>
                        <select class="form-select form-select-lg" name="status" id="status">
                            <option value="" {{!isset($filterParameters['status']) ? 'selected': ''}} > All </option>
                            @foreach(\App\Models\Todo::STATUS as $key => $value)
                                <option value="{{$key}}" {{ isset($filterParameters['status']) && $filterParameters['status'] == $key ? 'selected': '' }}>
                                    {{ucfirst($value)}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-12 mb-3">
                        <div class="d-flex float-end">
                            <button type="submit" class="btn btn-block btn-secondary me-2">Filter</button>
                            <a href="{{route('user.todos.index')}}" class="btn btn-block btn-primary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="list-unstyled mb-0 justify-content-center">
                            <a href="{{route('user.todos.create')}}" >
                                <button class="btn btn-sm btn-success" >
                                    <i class="link-icon" data-feather="plus"></i> Todo Create
                                </button>
                            </a>
                        </div>
                        <div class="mx-auto float-end">
                            <h4 class="text-primary mt-md-0 ">Todo Lists</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        @forelse($todoLists as $key => $value)
                            <div class="row align-items-center mb-4 border-bottom pb-3">
                            <div class="col-lg-8 d-flex align-items-center"
                                style="{{ $value->status == 'completed' ? 'text-decoration: Line-Through' :'' }}">
                                 <input type="checkbox"
                                        id="toggleTodoStatus"
                                        class="me-2 align-middle"
                                        name="status"
                                        value="0"
                                        {{ $value->status == 'completed' ? 'checked' : '' }}
                                        data-href="{{route('user.todos.change-status',$value->id)}}"
                            />
                                {{ $value->title }}
                            </div>

                            <div class="col-lg-2 text-end">
                                <ul class="d-flex list-unstyled mb-0 justify-content-center">
                                    <li class="me-2">
                                        <a href="{{route('user.todos.edit',$value->id)}}"
                                            title="show Client Detail">
                                            <i class="link-icon" data-feather="edit"></i>
                                        </a>
                                    </li>

                                    <li class="me-2  showTodoDetail">
                                        <a href="#"
                                           data-title="{{$value->title}}"
                                           data-description="{{$value->description}}"
                                           data-status="{{$value->status}}"
                                           data-image="{{\App\Models\Todo::UPLOAD_PATH.$value->image}}"
                                           data-deadline="{{$value->due_date}}"
                                           title="show Todo Detail">
                                            <i class="link-icon" data-feather="eye"></i>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#"
                                           class="delete"
                                           data-href="{{route('user.todos.delete',$value->id)}}"
                                           title="Delete Todo">
                                            <i class="link-icon"  data-feather="delete"></i>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        @empty
                            <tr>
                                <td colspan="100%">
                                    <p class="text-center"><b>No Todo records found !</b></p>
                                </td>
                            </tr>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
        <div class="dataTables_paginate mt-3">
            {{$todoLists->appends($_GET)->links()}}
        </div>
    </div>



@endsection

@section('scripts')
    @include('todos.common.scripts')
@endsection

