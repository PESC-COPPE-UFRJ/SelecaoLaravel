<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ Lang::get('reminders.title') }}</h2>

		<div>
			{{ Lang::get('reminders.link_reset') }} {{ URL::to('password/reset', array($token)) }}.<br/>
			{{-- Lang::get('reminders.expire_info', array('minutes' => Config::get('auth.reminder.expire' => 60))) --}}
		</div>
	</body>
</html>
