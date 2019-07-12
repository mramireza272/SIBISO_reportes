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
            @php($subChild = false)
            @foreach ($items_rol as $itm)
                <thead>
                    <tr>
                        <th>
                            <input class="form-control" type="text" name="" value="{{ $itm->item }}" data-type="item" data-id="{{ $itm->id }}" @if($action == 'show') readonly @endif />
                        </th>
                        <th>
                            <input class="magic-checkbox" type="checkbox" name="" id="{{ $itm->id }}" @if($action == 'show' || ($itm->childs->count() > 0)) disabled @endif @if($itm->editable) checked @endif />
                            <label for="{{ $itm->id }}">
                                Editable
                            </label>
                        </th>
                        @foreach ($itm->cols as $col)
                            <th>
                                <input class="form-control" type="text" name="col_{{ $col->id }}" data-type="rol" data-id="{{ $col->id }}" value="{{ $col->columns }}" @if($action == 'show') readonly @endif />
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
                    @foreach ($itm->childs as $subitm)
                        <tr>
                            <td>
                                <input class="form-control" type="text" name="row_{{ $subitm->id }}" data-type="item" data-id="{{ $subitm->id }}" value="{{ $subitm->item }}" @if($action == 'show') readonly @endif />
                            </td>
                            <td>
                                <input class="magic-checkbox" type="checkbox" name="{{ $subitm->id }}" id="{{ $subitm->id }}" @if($action == 'show') disabled @endif @if($subitm->editable) checked @endif />
                                <label for="{{ $subitm->id }}">
                                    Editable
                                </label>
                            </td>
                        </tr>
	                    @foreach ($subitm->childs as $subch)
	                        <tr>
	                            <td>
	                                <input class="form-control" type="text" name="row_{{ $subch->id }}" data-type="item" data-id="{{ $subch->id }}" value="{{ $subch->item }}" @if($action == 'show') readonly @endif />
	                            </td>
	                        </tr>
	                    @endforeach
                        @if($subitm->childs->count() > 0 && $action != 'show')
                            @php($subChild = true)
                            <tr id="rowSubChilds_{{ $subch->id }}" style="display: none;">
                            </tr>
                            <tr style="width: 100;">
                                <td>
                                    <a role="button" id="addRow" class="btn btn-info row-info" data-id="{{ $subch->id }}" data-rol="{{ $subitm->rol_id }}" data-parent="{{ $subitm->childs->first()->parent_id }}" data-row="child">[+]</a>
                                    <a role="button" id="removeRow" class="btn btn-danger row-danger" data-item="{{ $subitm->id }}" data-id="{{ isset($subitm->childs->last()->id) ? $subitm->childs->last()->id : '' }}">[-]</a>
                                </td>
                            </tr>
                        @endif
                        @if(($subitm->childs->count() == 0) && ($loop->last) && $subChild && ($action != 'show'))
                            <tr id="rowSubChildsLast" style="display: none;">
                            </tr>
                            <tr style="width: 100;">
                                <td>
                                    <a role="button" id="addRow" class="btn btn-info row-info" data-id="{{ $subitm->id }}" data-rol="{{ $subitm->rol_id }}" data-parent="{{ $subitm->parent_id }}" data-row="childlast">[+]</a>
                                    <a role="button" id="removeRow" class="btn btn-danger row-danger" data-item="{{ $subitm->parent_id }}" data-id="{{ isset($subitm->id) ? $subitm->id : '' }}">[-]</a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    @if(!$subChild && $action != 'show')
                        <tr id="rowChilds_{{ $subitm->id }}" style="display: none;">
                        </tr>
                        <tr style="width: 100;">
                            <td>
                                <a role="button" id="addRow" class="btn btn-info row-info" data-id="{{ $subitm->id }}" data-rol="{{ $subitm->rol_id }}" data-parent="{{ $subitm->parent_id }}">[+]</a>
                                <a role="button" id="removeRow" class="btn btn-danger row-danger" data-item="{{ $itm->id }}" data-id="{{ isset($itm->childs->last()->id) ? $itm->childs->last()->id : '' }}">[-]</a>
                            </td>
                        </tr>
                    @endif
                </tbody>
                @php($subChild = false)
            @endforeach
        </table>
    </div>
</div>
<div class="panel-footer text-right">
    <a role="button" href="{{ route('formularios.index') }}" class="btn btn-primary">Regresar</a>
</div>