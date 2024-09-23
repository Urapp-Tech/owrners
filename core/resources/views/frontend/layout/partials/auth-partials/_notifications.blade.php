@if (Auth::guard('web')->user()->user_type == 1)

    <div class="navbar-right-notification-wrapper-list">
        @if ($notifications->count() > 0)
            @foreach ($notifications as $notification)
                <span href="javascript:void(0)"
                    class="navbar-right-notification-wrapper-list-item click-notification">
                    <div class="navbar-right-notification-wrapper-list-item-left">
                        <div
                                class="navbar-right-notification-wrapper-list-item-icon decline">
                            <i class="fa-regular fa-bell"></i>
                        </div>
                    </div>
                    <div class="navbar-right-notification-wrapper-list-item-content">
                        @if ($notification->type == 'Offer')
                            <a
                                    href="{{ route('client.offer.details', $notification->identity) }}">
                                <span
                                        class="navbar-right-notification-wrapper-list-item-content-title">{{ $notification->message }}</span>
                            </a>
                            <span
                                    class="navbar-right-notification-wrapper-list-item-content-time">{{ $notification->created_at->toFormattedDateString() }}</span>
                        @endif
                        @if ($notification->type == 'Proposal')
                            <a
                                    href="{{ route('client.job.proposal.details', $notification->identity) }}">
                                <span
                                        class="navbar-right-notification-wrapper-list-item-content-title">{{ $notification->message }}</span>
                            </a>
                            <span
                                    class="navbar-right-notification-wrapper-list-item-content-time">{{ $notification->created_at->toFormattedDateString() }}</span>
                        @endif
                        @if ($notification->type == 'Order')
                            <a
                                    href="{{ route('client.order.details', $notification->identity) }}">
                                <span
                                        class="navbar-right-notification-wrapper-list-item-content-title">{{ $notification->message }}</span>
                            </a>
                            <span
                                    class="navbar-right-notification-wrapper-list-item-content-time">{{ $notification->created_at->toFormattedDateString() }}</span>
                        @endif
                        @if ($notification->type == 'Job')
                            <a
                                    href="{{ route('client.job.details', $notification->identity) }}">
                                <span
                                        class="navbar-right-notification-wrapper-list-item-content-title">{{ $notification->message }}</span>
                            </a>
                            <span
                                    class="navbar-right-notification-wrapper-list-item-content-time">{{ $notification->created_at->toFormattedDateString() }}</span>
                        @endif
                        @if ($notification->type == 'Account')
                            <a
                                    href="#">
                                <span
                                        class="navbar-right-notification-wrapper-list-item-content-title">{{ $notification->message }}</span>
                            </a>
                            <span
                                    class="navbar-right-notification-wrapper-list-item-content-time">{{ $notification->created_at->toFormattedDateString() }}</span>
                        @endif
                        @if ($notification->type == 'Ticket Update')
                            <a href="{{ route('client.ticket.details',$notification->identity) }}">
                            <span class="navbar-right-notification-wrapper-list-item-content-title">{{ $notification->message }}</span>
                        </a>
                            <span class="navbar-right-notification-wrapper-list-item-content-time">{{ $notification->created_at->toFormattedDateString() }}</span>
                        @endif
                    </div>
                </span>
            @endforeach
        @else
            <a href="javascript:void(0)"
            class="navbar-right-notification-wrapper-list-item click-notification">
                <div class="navbar-right-notification-wrapper-list-item-left">
                    <div class="navbar-right-notification-wrapper-list-item-icon decline">
                        <i class="fa-regular fa-bell"></i>
                    </div>
                </div>
                <div class="navbar-right-notification-wrapper-list-item-content">
                    <span
                            class="navbar-right-notification-wrapper-list-item-content-title">
                        <strong>{{ __('No Notification') }}</strong> </span>
                </div>
            </a>
        @endif
    </div>
@else

    <div class="navbar-right-notification-wrapper-list">
        @if ($notifications->count() > 0)
            @foreach ($notifications as $notification)
                <span href="javascript:void(0)"
                    class="navbar-right-notification-wrapper-list-item click-notification">
                    <div
                            class="navbar-right-notification-wrapper-list-item-left show_and_read_freelancer_notification">
                        <div
                                class="navbar-right-notification-wrapper-list-item-icon decline">
                            <i class="fa-regular fa-bell"></i>
                        </div>
                    </div>
                    <div class="navbar-right-notification-wrapper-list-item-content" data-type="{{$notification->type}}">

                        @if ($notification->type == 'Offer')
                            <a
                                    href="{{ route('freelancer.offer.details', $notification->identity) }}">
                                <span
                                        class="navbar-right-notification-wrapper-list-item-content-title">{{ $notification->message }}</span>
                            </a>
                            <span
                                    class="navbar-right-notification-wrapper-list-item-content-time">{{ $notification->created_at->toFormattedDateString() }}</span>
                        @endif

                        @if ($notification->type == 'Order')
                            <a
                                    href="{{ route('freelancer.order.details', $notification->identity) }}">
                                <span
                                        class="navbar-right-notification-wrapper-list-item-content-title">{{ $notification->message }}</span>
                            </a>
                            <span
                                    class="navbar-right-notification-wrapper-list-item-content-time">{{ $notification->created_at->toFormattedDateString() }}</span>
                        @endif

                        @if ($notification->type == 'Withdraw')
                            <a href="{{ route('freelancer.wallet.history') }}">
                                <span
                                        class="navbar-right-notification-wrapper-list-item-content-title">{{ $notification->message }}</span>
                            </a>
                            <span
                                    class="navbar-right-notification-wrapper-list-item-content-time">{{ $notification->created_at->toFormattedDateString() }}</span>
                        @endif

                        @if ($notification->type == 'Account')
                            <a
                                    href="#">
                                <span
                                        class="navbar-right-notification-wrapper-list-item-content-title">{{ $notification->message }}</span>
                            </a>
                            <span
                                    class="navbar-right-notification-wrapper-list-item-content-time">{{ $notification->created_at->toFormattedDateString() }}</span>
                        @endif

                        @if ($notification->type == 'Reject Gig')
                            <a href="{{ route('freelancer.profile.details',Auth::guard('web')->user()->username) }}">
                            <span
                                class="navbar-right-notification-wrapper-list-item-content-title">{{ $notification->message }}</span>
                        </a>
                            <span
                                    class="navbar-right-notification-wrapper-list-item-content-time">{{ $notification->created_at->toFormattedDateString() }}</span>
                        @endif

                            @if ($notification->type == 'Ticket Update')
                            <a href="{{ route('freelancer.ticket.details',$notification->identity) }}">
                                <span class="navbar-right-notification-wrapper-list-item-content-title">{{ $notification->message }}</span>
                            </a>
                                <span class="navbar-right-notification-wrapper-list-item-content-time">{{ $notification->created_at->toFormattedDateString() }}</span>
                            @endif
                    </div>
                </span>
            @endforeach
        @else
            <a href="javascript:void(0)"
            class="navbar-right-notification-wrapper-list-item click-notification">
                <div class="navbar-right-notification-wrapper-list-item-left">
                    <div class="navbar-right-notification-wrapper-list-item-icon decline">
                        <i class="fa-regular fa-bell"></i>
                    </div>
                </div>
                <div class="navbar-right-notification-wrapper-list-item-content">
                    <span
                            class="navbar-right-notification-wrapper-list-item-content-title">
                        <strong>{{ __('No Notification') }}</strong> </span>
                </div>
            </a>
        @endif
    </div>
@endif