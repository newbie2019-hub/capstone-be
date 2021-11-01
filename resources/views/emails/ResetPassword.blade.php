@component('mail::message')
Greetings, This is a generated message by the system. A password reset was requested by your account.
Please ignore this message if you didn't make this request.

Please click the link to reset your password.<br/>

@component('mail::button', ['url' => 'https://www.lnukiosk.live/account/reset?email='.$details['email'].'&token='.$details['token'].''])
Visit Site
@endcomponent

Thanks,<br>
System Admin
@endcomponent