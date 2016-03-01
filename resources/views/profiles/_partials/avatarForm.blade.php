<div id="imageModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Profile picture</h4>
            </div>
            <div class="modal-body">
                <!-- Display Validation Errors -->
                @if (count($errors) > 0)
                    @include('common.errors')
                @endif
                <div class="box">
                    <div class="form uploadBox">
                        {!! Form::open(array('id' => 'image_form', 'url' => 'profile/upload', 'class'=>'form-horizontal', 'files'=>true)) !!}
                        <div class="form-group">
                            <div id="image_preview" class="col-xs-offset-4 col-xs-4">
                                <img src="{{ $profile->avatar_url or '/img/avatar.png' }}" alt="Avatar" class="avatar img-thumbnail">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group col-xs-offset-2 col-xs-8">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse {!! Form::file('image') !!}
                                    </span>
                                </span>
                                {!! Form::text('image_file', null, ['id'=>'image_file', 'class'=>'form-control', 'readonly'=>true]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group col-xs-offset-2 col-xs-8">
                                <button id="image_submit" type="submit" class="btn btn-primary pull-right">
                                    <i class="fa fa-btn fa-upload"></i>Upload
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
