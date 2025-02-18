@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => ''])
{{$deliveryOrders}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
