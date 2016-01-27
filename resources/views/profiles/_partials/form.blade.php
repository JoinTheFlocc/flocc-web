<div class="form-group">
    {!! Form::label('firstname', 'First name', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('firstname', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('lastname', 'Last name', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('lastname', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('description', 'About me', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::textarea('description', null, ['class' => 'form-control', 'size' => '30x5']) !!}
    </div>
</div>

<div class="form-group">
    <label for="gender-sel" class="col-sm-2 control-label">Gender</label>
    <div class="col-sm-6">
        <select class="gender form-control" name="gender">
            <option value="n">unspecified</option>
            <option value="f">female</option>
            <option value="m">male</option>
            <option value="gq">non-binary</option>
        </select>
    </div>
</div>

<div class="form-group">
    <label for="country-sel" class="col-sm-2 control-label">Country</label>
    <div class="col-sm-6">
        @include('profiles._partials.countries')
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
        <button type="submit" class="btn btn-primary pull-right">
            <i class="fa fa-btn fa-save"></i>{{ $submitButton or "Save" }}
        </button>
    </div>
</div>
