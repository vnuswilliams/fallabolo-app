<x-mail::message>
# {{ $subjectText }}

{{ $messageContent }}

Merci,<br>
L'équipe {{ config('app.name') }}
</x-mail::message>
