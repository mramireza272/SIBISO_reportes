<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="panel-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
            	<label class="control-label" for="name"><strong>Nombre*</strong></label>
            	<input class="form-control" type="text" name="name" value="{{ $role->name ?? old('name') }}">
                {!! $errors->first('name', '<small class="help-block text-danger">:message</small>')!!}
            </div>
      	</div>
      	<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="form-group">
            	<label class="control-label">Lista de Roles</label>
              {!! $errors->first('permissions', '<small class="help-block text-danger">:message</small>')!!}
            	<ul class="list-unstyled">
      					@foreach($permissions as $permission)
      						<li>
      							<label>
                      @if(session()->getOldInput('permissions') !== null)
                          @php($permission_ids = collect(session()->getOldInput('permissions')))
                      @elseif($role->permissions)
                          @php($permission_ids = $role->permissions)
                      @else
                          @php($permission_ids = collect())
                      @endif
                  		<input {{($permission_ids->contains($permission->id)) ? "checked" : "" }} name="permissions[]" type="checkbox" value="{{$permission->id}}">
      								<strong>{{ $permission->name }}</strong>
      								<em>({{ $permission->description ?: 'Sin descripción' }})</em>
      							</label>
      						</li>
      					@endforeach
      				</ul>
              {!! $errors->first('permissions', '<small class="help-block text-danger">:message</small>')!!}
            </div>
      	</div>
    </div>
</div>
<div class="panel-footer text-right">
    <a role="button" class="btn btn-primary" href="{{ route('roles.index') }}">Regresar</a>
    <button type="submit" class="btn btn-primary">{{ isset($btnText) ? $btnText : 'Guardar'}}</button>
</div>