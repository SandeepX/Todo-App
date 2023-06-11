<div class="row">
    <div class="col-lg-6 mb-3">
        <label for="title" class="form-label">Title <span style="color: red">*</span></label>
        <input type="text"
               class="form-control"
               id="name"
               name="title"
               required
               value="{{ isset($todoDetail) ? $todoDetail->title : old('title')}}"
               autocomplete="off"
               placeholder="Enter Todo Title">
    </div>

    <div class="col-lg-6 mb-3">
        <label for="description" class="form-label">Description<span style="color: red">*</span></label>
        <textarea class="form-control tinymce-editor" id="description" name="description" >
            {{ isset($todoDetail) ? $todoDetail->description : old('description')}}
        </textarea>
    </div>

    <div class="col-lg-6 mb-3">
        <label for="title" class="form-label">Deadline<span style="color: red">*</span></label>
        <input type="date"
               class="form-control"
               id="dueDate"
               name="due_date"
               required
               value="{{ isset($todoDetail) ? $todoDetail?->due_date : old('due_date')}}"
               autocomplete="off" >
    </div>

    <div class="col-lg-6 mb-3">
        <label for="status" class="form-label">status <span style="color: red">*</span></label>
        <select class="form-select" id="status" name="status" {{ isset($todoDetail) ? 'required':''}}>
            <option value="" {{ (isset($todoDetail) && $todoDetail->status)  ? '': 'selected'}}> Select Status </option>
            @foreach(\App\Models\Todo::STATUS as $key => $value)
                <option value="{{$key}}" {{ isset($todoDetail) && ($todoDetail->status ) == $key || !is_null(old('status')) && old('status') == $key ?'selected': '' }}>
                    {{ucfirst($value)}}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-6 mb-3">
        <label for="image" class="form-label">Upload Image  </label>
        <input class="form-control"
               type="file"
               id="image"
               name="image"
               accept=".jpeg,.png,.jpg,.webp"
               value="{{ isset($todoDetail) ? $todoDetail?->image : old('image') }}"
        >
        <img class="mt-3 {{(isset($todoDetail) && $todoDetail->image) ? '': 'd-none'}}"
             id="image-preview"
             src="{{ (isset($todoDetail) && $todoDetail->image) ? asset(\App\Models\Todo::UPLOAD_PATH.$todoDetail->image) : ''}}"
             style="object-fit: contain"
             width="200"
             height="200"
        >
    </div>

    <div class="col-lg-12">
        <button type="submit" class="btn btn-success btn-md">
            <i class="link-icon" data-feather="{{isset($todoDetail)? 'edit-2':'plus'}}"></i>
           {{isset($todoDetail) ? 'Update': 'Create'}}
        </button>
    </div>

</div>







