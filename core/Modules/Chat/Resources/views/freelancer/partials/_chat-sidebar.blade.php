@if($freelancer_chat_list->count() > 0)

    @foreach($freelancer_chat_list as $freelancer_chat)
        <x-chat::freelancer.client-list :freelancerChat="$freelancer_chat" />
    @endforeach

@else
    <h4 class="text-danger text-center mt-5">{{ __('No Contacts Yet.') }}</h4>

@endif