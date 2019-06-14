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
                            <input class="magic-checkbox" type="checkbox" name="" id="{{ $itm->id }}" @if($action == 'show' || ($itm->childs->count() > 0)) disabled @endif @if($itm->editable) checked @endif />
                            <label for="{{ $itm->id }}">
                                Editable
                            </label>
                            {!! $errors->first('', '<small class="help-block text-danger">:message</small>')!!}
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
                                <a role="button" id="addCol" class="btn btn-info col-info" value="{{ $itm->id }}">[+]</a>
                                @if($itm->cols->count() > 0)
                                <a role="button" id="removeCol" class="btn btn-danger col-danger" data-item="{{ $itm->id }}" data-structure="{{ isset($itm->cols->last()->id) ? $itm->cols->last()->id : '' }}">[-]</a>
                                @endif
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php($subChild = false)
                    @foreach ($itm->childs as $subitm)
                        <tr>
                            <td>
                                <input type="text" name="" data-type="item" data-id="{{ $subitm->id }}" value="{{ $subitm->item }}" @if($action == 'show') readonly @endif />
                            </td>
                            <td>
                                <input class="magic-checkbox" type="checkbox" name="" id="{{ $subitm->id }}" @if($action == 'show') disabled @endif @if($subitm->editable) checked @endif />
                                <label for="{{ $subitm->id }}">
                                    Editable
                                </label>
                                {!! $errors->first('', '<small class="help-block text-danger">:message</small>')!!}
                            </td>
                        </tr>
	                    @foreach ($subitm->childs as $subch)
	                        <tr>
	                            <td>
	                                <input type="text" name="row_{{ $subch->id }}" data-type="item" data-id="{{ $subch->id }}" value="{{ $subch->item }}" @if($action == 'show') readonly @endif />
	                            </td>
	                        </tr>
	                    @endforeach
                        @if($subitm->childs->count() > 0 && $action != 'show')
                            @php($subChild = true)
                            <tr id="rowSubChilds" style="display: none;">
                            </tr>
                            <tr style="width: 100;">
                                <td>
                                    <a role="button" id="addRow" class="btn btn-info row-info" data-rol="{{ $subitm->rol_id }}" data-parent="{{ $subitm->childs->first()->parent_id }}">[+]</a>
                                    <a role="button" id="removeRow" class="btn btn-danger row-danger" data-item="{{ $subitm->id }}" data-structure="{{ isset($subitm->childs->last()->id) ? $subitm->childs->last()->id : '' }}">[-]</a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    @if(!$subChild && $action != 'show')
                        <tr id="rowChilds" style="display: none;">
                        </tr>
                        <tr style="width: 100;">
                            <td>
                                <a role="button" id="addRow" class="btn btn-info row-info" data-rol="{{ $subitm->rol_id }}" data-parent="{{ $subitm->parent_id }}">[+]</a>
                                <a role="button" id="removeRow" class="btn btn-danger row-danger" data-item="{{ $subitm->id }}" data-structure="{{ isset($subitm->childs->last()->id) ? $subitm->childs->last()->id : '' }}">[-]</a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            @endforeach
        </table>
    </div>
</div>
<div class="panel-footer text-right">
    <a role="button" href="{{ route('formularios.index') }}" class="btn btn-primary">Regresar</a>
</div>