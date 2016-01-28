<table class="table table-bordered">
    <thead>
    <tr>
        <th>&nbsp;</th>
        <th>Imię i nazwisko</th>
        @if($tab != 'followers')
            <th class="text-center">Opcje</th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td class="text-center">
                <a href="{{ URL::route('profile.display', ['id' => $user->getUserId()]) }}">
                    <img src="{{ $user->getUser()->getProfile()->getAvatarUrl() }}">
                </a>
            </td>
            <td>
                <a href="{{ URL::route('profile.display', ['id' => $user->getUserId()]) }}">
                    {{ $user->getUser()->getProfile()->getFirstName() }} {{ $user->getUser()->getProfile()->getLastName() }}
                </a>
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