@component('mail::message')
# Contact Message

Name: {{ $name }}  
Email: {{ $email }}  
@if(!is_null($phone))
Phone: {{ $phone }}  
@endif
Message:  
{{ $message }}
@endcomponent
