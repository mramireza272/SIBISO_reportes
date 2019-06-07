<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="rol_id" value="{{ $rol->id }}">
<input type="hidden" name="action" value="{{ $action }}">
<div class="form-group">
    <label class="control-label col-sm-4 col-md-4 col-lg-4 col-xl-4"><strong>Área a la que pertenece:</strong></label>
    <label class="control-label col-sm-4 col-md-4 col-lg-4 col-xl-4">{{ isset($rol->name) ? $rol->name : '' }}</label>
</div>
<div class="form-group">
    <label class="control-label col-sm-4 col-md-4 col-lg-4 col-xl-4"><strong>Periodo al que corresponde la información: *</strong></label>
    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
        <input autocomplete="off" type='text' class="form-control date fechapicker" name="date_start" value="{{ old('date_start') ?? $report->date_start }}" placeholder="Fecha de inicio del periodo" />
        {!! $errors->first('date_start', '<small class="help-block text-danger">:message</small>') !!}
    </div>
    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
        <input autocomplete="off" type='text' class="form-control date fechapicker" name="date_end" value="{{ old('date_end') ?? $report->date_end }}" placeholder="Fecha del fin del periodo" />
        {!! $errors->first('date_end', '<small class="help-block text-danger">:message</small>') !!}
    </div>
</div>
<div class="panel-body">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="form-group">
                <table id="example" class="display" style="width:100%">
                    @foreach ($items_rol as $itm)
                        <thead>
                            <tr style="border:1px dotted black; margin:5px;">
                                <th style="text-align: center;">{{ $itm->item }}</th>
                                @foreach ($itm->cols as $col)
                                    <th>{{ $col->columns }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($itm->childs as $ch)
                            <tr style="border:1px dotted black; margin:5px;">
                                <td>{{ $ch->item }}</td>
                                @foreach ($itm->cols as $col)
                                    @if($action == 'create')
                                        @php($input_name = 'f_'. $rol->id .'_'. $col->id .'_'. $ch->id)
                                    @else
                                        @php($input_name = 'f_'. (isset($vals[$col->id][$ch->id]['id']) ? $vals[$col->id][$ch->id]['id'] : ''))
                                    @endif
                                    @if($ch->editable)
                                        <td>
                                            <input type="text" name="{{ $input_name }}" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ old('f_'. $rol->id .'_'. $col->id .'_'. $ch->id) ?? (isset($vals[$col->id][$ch->id]['value']) ? $vals[$col->id][$ch->id]['value'] : '') }}" />
                                            {!! $errors->first($input_name, '<small class="help-block text-danger">:message</small>')!!}
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                            @foreach($ch->childs as $subch)
                                <tr style="border:1px dotted black; margin:5px;">
                                    <td>{{ $subch->item }}</td>
                                    @foreach ($itm->cols as $col)
                                        @if($action == 'create')
                                            @php($input_name = 'f_'. $rol->id .'_'. $col->id .'_'. $subch->id)
                                        @else
                                            @php($input_name = 'f_'. $vals[$col->id][$subch->id]['id'])
                                        @endif
                                        <td>
                                            <input type="text" name="{{ $input_name }}" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ old('f_'. $rol->id .'_'. $col->id .'_'. $subch->id) ?? (isset($vals[$col->id][$subch->id]) ? $vals[$col->id][$subch->id] : '') }}"/>
                                            {!! $errors->first($input_name, '<small class="help-block text-danger">:message</small>')!!}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
<div class="panel-footer text-right">
    <a role="button" href="{{ route('forma.index') }}" class="btn btn-primary">Regresar</a>
    <button type="submit" class="btn btn-primary">{{ isset($btnText) ? $btnText : 'Guardar'}}</button>
</div>