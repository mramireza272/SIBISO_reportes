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
                            <input type="text" name="" value="{{ $itm->item }}" data-type="item" data-id="{{ $itm->id }}" @if($action == 'show') readonly @endif />
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
                                <input type="text" name="col_{{ $col->id }}" data-type="rol" data-id="{{ $col->id }}" value="{{ $col->columns }}" @if($action == 'show') readonly @endif />
                                {!! $errors->first('col_'. $col->id, '<small class="help-block text-danger">:message</small>')!!}
                            </th>
                        @endforeach

                        <th id="col" style="display: none;">
                        </th>

                        @if(!$itm->editable && $action != 'show')
                            <th style="width: 100;">
                                <a role="button" id="addCol" class="btn btn-info" value="{{ $itm->id }}">[+]</a>
                                @if($itm->cols->count() > 0)
                                <a role="button" id="removeCol" class="btn btn-danger" data-item="{{ $itm->id }}" data-structure="{{ isset($itm->cols->last()->id) ? $itm->cols->last()->id : '' }}">[-]</a>
                                @endif
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($itm->childs as $subitm)
                        <tr>
                            <td>
                                <input type="text" name="" data-type="item" data-id="{{ $subitm->id }}" value="{{ $subitm->item }}">
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            @endforeach
        </table>
    </div>
</div>
<div class="panel-footer text-right">
    <a role="button" href="{{ route('formularios.index') }}" class="btn btn-primary">Regresar</a>
   {{--  @if($action != 'show')
        <button type="submit" class="btn btn-primary">{{ isset($btnText) ? $btnText : 'Guardar'}}</button>
    @endif --}}
</div>