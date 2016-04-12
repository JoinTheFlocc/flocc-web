<table class="table table-bordered">
    <thead>
    <tr>
        <th>&nbsp;</th>
        <th>Imię i nazwisko</th>
        <th>Dopasowanie</th>
        @if($tab != 'followers')
            <th class="text-center">Opcje</th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <?php $profile = $user->getUser()->getProfile(); ?>
        <tr>
            <td class="text-center">
                <a href="{{ URL::route('profile.display', $profile->getId()) }}">
                    <img src="{{ $profile->getAvatarUrl() }}" class="img-responsive img-thumbnail img-rounded avatar-lg">
                </a>
            </td>
            <td>
                <a href="{{ URL::route('profile.display', $profile->getId()) }}">
                    {{ $profile->getFirstName() }} {{ $profile->getLastName() }}
                </a>
            </td>
            <td>
                <span class="btn btn-success">
                    {{ $profile->getEventScoring($event->getId()) }}%
                </span>
            </td>
            @if($tab == 'awaiting')
                <td class="text-center">
                    <a href="{{ URL::route('events.edit.members.status', ['id' => $event->getId(), 'user_id' => $user->getUserId(), 'status' => 'member']) }}" class="btn btn-success">
                        Akceptuj
                    </a>
                    <a href="{{ URL::route('events.edit.members.status', ['id' => $event->getId(), 'user_id' => $user->getUserId(), 'status' => 'rejected']) }}" class="btn btn-danger">
                        Odrzuć
                    </a>
                </td>
            @endif
            @if($tab == 'members')
                <td class="text-center">
                    <a href="{{ URL::route('events.edit.members.status', ['id' => $event->getId(), 'user_id' => $user->getUserId(), 'status' => 'rejected']) }}" class="btn btn-danger">
                        Usuń
                    </a>
                </td>
            @endif
            @if($tab == 'rejected')
                <td class="text-center">
                    <a href="{{ URL::route('events.edit.members.status', ['id' => $event->getId(), 'user_id' => $user->getUserId(), 'status' => 'member']) }}" class="btn btn-success">
                        Przywróć
                    </a>
                </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
