<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="rol_id" value="{{ $rol->id }}">
{!! $errors !!}
<div class="panel-body">
    <div class="form-group">
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <label class="control-label"><strong>Área a la que pertenece:</strong></label>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
            <label class="control-label">{{ isset($rol->name) ? $rol->name : '' }}</label>
        </div>
    </div>
    <br/><br/>
    <div class="form-group">
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <label class="control-label"><strong>Periodo al que corresponde la información *</strong></label>
        </div>
        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <input autocomplete="off" type='text' class="form-control input-group date fechapicker" name="date_start" value="{{ old('date_start') ?? $report->date_start }}" placeholder="Fecha de inicio del periodo" />
            {!! $errors->first('date_start', '<small class="help-block text-danger">:message</small>') !!}
        </div>
        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <input autocomplete="off" type='text' class="form-control input-group date fechapicker" name="date_end" value="{{ old('date_end') ?? $report->date_end }}" placeholder="Fecha del fin del periodo" />
            {!! $errors->first('date_end', '<small class="help-block text-danger">:message</small>') !!}
        </div>
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
                                    @if($ch->editable)
                                        <td>
                                            <input type="text" name="f_{{ $rol->id .'_'. $col->id .'_'. $ch->id }}" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ old('f_'. $rol->id .'_'. $col->id .'_'. $ch->id) ?? isset($vals[$col->id][$ch->id]) ? $vals[$col->id][$ch->id] : '' }}" />
                                            {!! $errors->first('f_'. $rol->id .'_'. $col->id .'_'. $ch->id, '<small class="help-block text-danger">:message</small>')!!}
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                            @foreach($ch->childs as $subch)
                                <tr style="border:1px dotted black; margin:5px;">
                                    <td>{{ $subch->item }}</td>
                                    @foreach ($itm->cols as $col)
                                        <td>
                                            <input type="text" name="f_{{ $rol->id .'_'. $col->id .'_'. $subch->id }}" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="{{ old('f_'. $rol->id .'_'. $col->id .'_'. $subch->id) ?? isset($vals[$col->id][$subch->id]) ? $vals[$col->id][$subch->id] : ''}}"/>
                                            {!! $errors->first('f_'. $rol->id .'_'. $col->id .'_'. $subch->id, '<small class="help-block text-danger">:message</small>')!!}
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