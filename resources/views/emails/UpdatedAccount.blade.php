@component('mail::message')
Greetings, {{$first_name}} {{$last_name}} your account was updated by the system administrator.
Here is your updated information.

Updated User Information <br/>
First Name: {{$first_name}} <br/>
Middle Name: {{$middle_name}} <br/>
Last Name: {{$last_name}} <br/>
Gender: {{$gender}} <br/>
Email: {{$email}}

@component('mail::button', ['url' => 'https://touchless-management.herokuapp.com'])
Visit Site
@endcomponent

Thanks,<br>
System Admin
@endcomponent