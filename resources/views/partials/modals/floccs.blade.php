<div id="floccsModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ URL::route('profile.edit.floccs') }}">
                <div class="modal-header">
                    <h4 class="modal-title">Krótka ankieta</h4>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}

                    <div>
                        <strong>Co</strong>

                        <div>
                            <select name="activity_id" class="form-control">
                                <option value="" selected="selected">Wybierz</option>
                                @foreach($activities as $activity)
                                    <option value="{{ $activity->getId() }}" @if($user_flocc !== null and $user_flocc->getActivityId() === $activity->getId()) selected="selected" @endif>{{ $activity->getName() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><br>

                    <div>
                        <strong>Gdzie</strong>

                        <div>
                            <input type="text" name="place" class="form-control place_auto_complete" autocomplete="off" @if($user_flocc !== null) value="{{ $user_flocc->getPlace() }}" @endif>
                        </div>
                    </div><br>

                    <div>
                        <strong>Jak</strong>

                        <div>
                            @foreach($tribes as $tribe)
                                <label style="margin-right: 10px;">
                                    <input type="checkbox" name="tribes[]" value="{{ $tribe->getId() }}" @if($user_flocc !== null and in_array($tribe->getId(), $user_flocc->getTribes())) checked="checked" @endif> {{ $tribe->getName() }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ URL::route('profile.edit.floccs.cancel') }}" type="submit" class="btn btn-default">Anuluj</a>
                    <button class="btn btn-success pull-left">Zapisz</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->