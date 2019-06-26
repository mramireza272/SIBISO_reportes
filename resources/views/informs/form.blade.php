<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
    <label class="col-md-3 control-label" for="rol_id"><strong>Unidad Administrativa Responsable*</strong></label>
    <div class="col-md-9">
        <select data-placeholder="Seleccione una Unidad Administrativa Responsable" id="rol_id" name="rol_id" class="form-control">
        	<option value=""></option>
        	@foreach($roles as $role)
                <option value="{{ $role->id }}" {{ (old('rol_id') == $role->id ? 'selected' : '') }}> {{ $role->name }}</option>
            @endforeach
        </select>
        {!! $errors->first('rol_id', '<small class="help-block text-danger">:message</small>') !!}
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label" for="theme_result"><strong>Tema*</strong></label>
    <div class="col-md-9">
        <input type="text" id="theme_result" name="theme_result" class="form-control" placeholder="Ingrese el tema" value="{{ old('theme_result', $inform->theme_result) }}" />
        {!! $errors->first('theme_result', '<small class="help-block text-danger">:message</small>') !!}
    </div>
</div>
<div class="panel-footer text-right">
	<a role="button" href="{{ route('informes.index') }}" class="btn btn-primary">Regresar</a>
	<button type="submit" class="btn btn-primary">Guardar</button>
</div>