<style>
    .alert-warning {
        background: rgba(251 188 5 / 10%);
        color: rgba(251, 123, 5, 1);
        border-radius: 33px;
        padding: 5px 15px;
    }
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

    span.alert{
        margin-bottom: 0;
        word-break: keep-all;
    }
</style>

@if($status === 0)
    <span class="alert alert-warning">{{__('Inactive')}}</span>
@elseif($status === 1)
    <span class="alert alert-success" >{{__('Active')}}</span>
@endif
