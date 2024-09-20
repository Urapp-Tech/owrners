@if($client_chat_list->count() > 0)

    @foreach($client_chat_list as $client_chat)
        <x-chat::client.freelancer-list :clientChat="$client_chat" />
    @endforeach

@else
    <h4 class="text-danger text-center mt-5">{{ __('No Contacts Yet.') }}</h4>

@endif