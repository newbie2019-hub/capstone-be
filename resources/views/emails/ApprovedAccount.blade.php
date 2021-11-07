@component('mail::message')
Greetings, {{$last_name}} your account was approved by the system administrator.
You can now sign-in to your account.
<br/>
User Information <br/>
First Name: {{$first_name}} <br/>
Middle Name: {{$middle_name}} <br/>
Last Name: {{$last_name}} <br/>
Email: {{$email}}

@component('mail::button', ['url' => 'https://www.lnukiosk.live'])
Visit Site
@endcomponent

Thanks,<br>
System Admin
@endcomponent