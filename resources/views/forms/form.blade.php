<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="rol_id" value="{{ $rol->id }}">
<input type="hidden" name="action" value="{{ $action }}">
<div class="form-group">
    <label class="control-label col-sm-4 col-md-4 col-lg-4 col-xl-4"><strong>Área a la que pertenece:</strong></label>
    <label class="control-label col-sm-4 col-md-4 col-lg-4 col-xl-4">{{ isset($rol->name) ? $rol->name : '' }}</label>
</div>
<div class="panel-body">
    <div class="table-responsive">
        <table id="example" class="table table-striped" style="width: 100%">
            @foreach ($items_rol as $itm)
                <thead>
                    <tr>
                        <th>
                            <input type="text" name="" value="{{ $itm->item }}" @if($action == 'show') readonly @endif />
                            {!! $errors->first('', '<small class="help-block text-danger">:message</small>')!!}
                        </th>
                        <th>
                            <input class="magic-checkbox" type="checkbox" name="" id="editable" @if($action == 'show') disabled @endif @if($itm->editable) checked @endif />
                            <label for="editable">
                                Editable
                            </label>
                            {!! $errors->first('editable', '<small class="help-block text-danger">:message</small>')!!}
                        </th>
                        @foreach ($itm->cols as $col)
                            <th>
                                <input type="text" name="col_{{ $col->id }}" value="{{ $col->columns }}" @if($action == 'show') readonly @endif />
                                {!! $errors->first('col_'. $col->id, '<small class="help-block text-danger">:message</small>')!!}
                            </th>
                        @endforeach

                        @if(!$itm->editable && $action != 'show')
                            <th>
                                <a role="button" id="addCol" class="btn btn-info" value="{{ $itm->id }}">[+]</a>
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($itm->childs as $subitm)
                        <tr>
                            <td>
                                <input type="text" name="" value="{{ $subitm->item }}">
                            </td>
                        </tr>
                    @endforeach
                 {{--@foreach($itm->childs as $ch)
                    <tr>
                        <td>{{ $ch->item }}</td>
                        @foreach ($itm->cols as $col)
                            @if($action == 'create')
                                @php($input_name = 'f_'. $rol->id .'_'. $col->id .'_'. $ch->id)
                            @else
                                @php($input_name = 'f_'. (isset($vals[$col->id][$ch->id]['id']) ? $vals[$col->id][$ch->id]['id'] : ''))
                            @endif
                            @if($ch->editable)
                                <td>
                                    <input type="text" name="{{ $input_name }}" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ old('f_'. $rol->id .'_'. $col->id .'_'. $ch->id) ?? (isset($vals[$col->id][$ch->id]['value']) ? $vals[$col->id][$ch->id]['value'] : 0) }}" @if($action == 'show') readonly @endif />
                                    {!! $errors->first($input_name, '<small class="help-block text-danger">:message</small>')!!}
                                </td>
                            @endif
                        @endforeach
                    </tr>
                    @foreach($ch->childs as $subch)
                        <tr>
                            <td>{{ $subch->item }}</td>
                            @foreach ($itm->cols as $col)
                                @if($action == 'create')
                                    @php($input_name = 'f_'. $rol->id .'_'. $col->id .'_'. $subch->id)
                                @else
                                    @php($input_name = 'f_'. $vals[$col->id][$subch->id]['id'])
                                @endif
                                <td>
                                    <input type="text" name="{{ $input_name }}" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ old('f_'. $rol->id .'_'. $col->id .'_'. $subch->id) ?? (isset($vals[$col->id][$subch->id]['value']) ? $vals[$col->id][$subch->id]['value'] : 0) }}" @if($action == 'show') readonly @endif />
                                    {!! $errors->first($input_name, '<small class="help-block text-danger">:message</small>')!!}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @endforeach--}}
                </tbody>
            @endforeach
        </table>
    </div>
</div>
<div class="panel-footer text-right">
    <a role="button" href="{{ route('formularios.index') }}" class="btn btn-primary">Regresar</a>
    @if($action != 'show')
        <button type="submit" class="btn btn-primary">{{ isset($btnText) ? $btnText : 'Guardar'}}</button>
    @endif
</div>