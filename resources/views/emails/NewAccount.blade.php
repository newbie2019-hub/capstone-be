@component('mail::message')
Greetings, This is a generated message by the system. An account was created for you 
by the system administrator.

Here are your informations.<br/>

First Name: {{$details['first_name']}} <br/>
Middle Name: {{$details['middle_name']}} <br/>
Last Name: {{$details['last_name']}} <br/>
Gender: {{$details['gender']}} <br/>
Email: {{$details['email']}} <br/>
Password: {{$details['password']}} <br/>
Account Type: {{$details['account_type']}}
@component('mail::button', ['url'=> 'https://touchless-management.herokuapp.com'])
Visit Site
@endcomponent

Thanks,<br>
System Admin
@endcomponent