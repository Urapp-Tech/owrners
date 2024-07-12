<style>
    .alert-success {
        border: none;
        background-color: rgba(0, 210, 162, 0.1);
        color: rgba(0, 210, 162, 1);
        border-radius: 33px;
        padding:5px 15px;

    }
    .alert-danger {
        border: none;
        background-color: rgba(255, 94, 78, 0.1);
        color: rgba(255, 94, 78, 1);
        border-radius: 33px;
        padding:5px 15px;

    }
</style>

@if($status === 0)
    <span class="alert alert-danger" >{{__('Not Verified')}}</span>
@elseif($status === 1)
    <span class="alert alert-success" >{{__('Verified')}}</span>
@endif
