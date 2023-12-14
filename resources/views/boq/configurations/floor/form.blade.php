@csrf
<div class="row">
    <div class="col-xl-12 col-md-12 mt-2">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="effective_date">Select Type<span class="text-danger">*</span></label>
            <select name="type_id" id="type_id" class="form-control select2" required>
                <option value="">-- Select Floor type --</option>
                @foreach($floor_types as $type)
                <option value="{{ $type->id }}" @if ($type->id == old('type_id', $floor->type_id ?? -1)) selected @endif>{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-xl-12 col-md-12 mt-2">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="effective_date">Parent Floor</label>
            <select name="parent_id" id="parent_id" class="form-control select2">
                <option value="">-- Select Parent Floor --</option>
                @foreach($floors as $single_floor)
                    <option value="{{ $single_floor->id }}" @if ($single_floor->id == old('parent_id', $floor->parent_id ?? -1)) selected @endif>{{ $single_floor->name }}</option>
                    @if (count($single_floor->children) > 0)
                        @include('boq.configurations.floor.subfloor', ['floors' => $single_floor->children, 'prefix' => '-'])
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-xl-12 col-md-12 mt-2">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="effective_date">Floor Name<span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" required value="{{ old('name', $floor->name ?? '') }}" placeholder="Enter floor name" autocomplete="off" class="form-control">
        </div>
    </div>
    <input name="account_id" type="hidden" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">

</div>
