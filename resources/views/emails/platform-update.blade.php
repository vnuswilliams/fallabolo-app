<x-mail::message>
# {{ $subjectText }}

{{ $messageContent }}

---

Merci de faire confiance à **{{ config('app.name') }}**, la plateforme de recrutement intelligente du Cameroun.

<x-mail::button :url="config('app.url')">
Accéder à la plateforme
</x-mail::button>

*Vous recevez cet email car vous êtes inscrit aux mises à jour de {{ config('app.name') }}.*
*Pour vous désabonner, rendez-vous dans vos [paramètres]({{ config('app.url') }}/settings).*

L'équipe {{ config('app.name') }}
</x-mail::message>
