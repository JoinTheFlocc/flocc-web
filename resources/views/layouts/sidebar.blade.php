<div class="contentBox">
	<div class="panel panel-default panel-sidebar">
		<div class="panel-heading">
			<h4 class="panel-title">Settings</h4>
		</div>
		<div class="panel-body">
			<div class="list-group settings">
				<a href="{{ URL::route('profile.edit', Auth::user()->profile->id) }}" class="list-group-item">Profile</a>
				<a href="{{ URL::route('settings.account') }}" class="list-group-item">Account settings</a>
				<a href="{{ URL::route('settings.notifications') }}" class="list-group-item">Notification center</a>
			</div>
		</div>
	</div>
</div>
