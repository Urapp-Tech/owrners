<style>
    .queue-order {
       background: rgba(251 188 5 / 10%);
        color: rgba(251, 123, 5, 1);
        border-radius: 33px;
        padding: 5px 15px;
    }
    .active-order, .complete-order {
        border: none;
        background-color: rgba(0, 210, 162, 0.1);
        color: rgba(0, 210, 162, 1);
        border-radius: 33px;
        padding:5px 15px;

    }
    .deliver-order {
        border: none;
        background-color: rgba(51, 187, 197, 0.1);
        color: rgba(51, 187, 197, 1);
        border-radius: 33px;
        padding:5px 15px;
    }
    .cancel-order, .decline-order {
        border: none;
        background-color: rgba(255, 94, 78, 0.1);
        color: rgba(255, 94, 78, 1);
        border-radius: 33px;
        padding:5px 15px;
    }
    .cancel-order {
        background: rgba(251 188 5 / 10%);
        color: rgba(251, 123, 5, 1);
        border-radius: 33px;
        padding: 5px 15px;
    }
</style>

@if($status === 0)
    <span class="queue-order" >{{__('Queue')}}</span>
@elseif($status === 1)
    <span class="active-order" >{{__('Active')}}</span>
@elseif($status === 2)
    <span class="deliver-order" >{{__('Delivered')}}</span>
@elseif($status === 3)
    <span class="complete-order" >{{__('Complete')}}</span>
@elseif($status === 4)
    <span class="cancel-order" >{{__('Cancel')}}</span>
@elseif($status === 5)
    <span class="decline-order" >{{__('Decline')}}</span>
@elseif($status === 7)
    <span class="hold-order" >{{__('Hold')}}</span>
@endif
