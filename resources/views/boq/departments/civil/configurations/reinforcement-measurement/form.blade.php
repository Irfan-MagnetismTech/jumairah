@csrf
<div class="row">
    <div class="col-xl-10 col-md-10 mt-2">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="effective_date">Select Unit<span class="text-danger">*</span></label>
            <select name="unit_id" id="unit_id" class="form-control" required>
                <option value="">-- Select Unit --</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}" @if ($unit->id == old('unit_id', $reinforcementMeasurement->unit_id ?? -1)) selected @endif>{{ $unit->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-xl-10 col-md-10 mt-2">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="effective_date">Dia<span class="text-danger">*</span></label>
            <input type="number" name="dia" id="dia" required value="{{ old('dia', $reinforcementMeasurement->dia ?? '') }}" placeholder="Enter dia" autocomplete="off" class="form-control">
        </div>
    </div>

    <div class="col-xl-10 col-md-10 mt-2">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="effective_date">Weight<span class="text-danger">*</span></label>
            <input type="text" name="weight" id="weight" required value="{{ old('weight', $reinforcementMeasurement->weight ?? '') }}" placeholder="Enter weight" autocomplete="off" class="form-control">
        </div>
    </div>


</div>
