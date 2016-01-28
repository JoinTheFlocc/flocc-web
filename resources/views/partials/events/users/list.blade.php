<table class="table table-bordered">
    <thead>
    <tr>
        <th>&nbsp;</th>
        <th>Imię i nazwisko</th>
        @if($tab == 'awaiting')
            <th>Opcje</th>
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
                <td>
                    <a href="#" class="btn btn-success">
                        Akceptuj
                    </a>
                    <a href="#" class="btn btn-danger">
                        Odrzuć
                    </a>
                </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>