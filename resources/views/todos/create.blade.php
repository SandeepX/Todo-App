@extends('layouts.app')
@section('title','Todo Create')
@section('content')
    <section class="content">
        <div class="container">
            @include('layouts.flash_message')
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="list-unstyled mb-0 justify-content-center">
                            <a href="{{route('user.todos.index')}}" >
                                <button class="btn btn-sm btn-danger" ><i class="link-icon" data-feather="arrow-left"></i> Back</button>
                            </a>
                        </div>
                        <div class="mx-auto float-end">
                            <h4 class="text-primary mt-md-0 ">Todo Create</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <form id="" class="forms-sample"
                              action="{{route('user.todos.store')}}"
                              enctype="multipart/form-data"
                              method="POST">
                            @csrf
                            @include('todos.common.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    @include('todos.common.scripts')
@endsection


