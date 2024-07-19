@if ($search_terms->count() >= 1 || count($services) > 0)
   
    @if ($old_searches && count( $old_searches)> 0 )
        <div class="services-suggestions">
            <h6>Recent Searches</h6>
            <ul>
                @foreach ($old_searches as $item)
                    
                    <li class="suggestion-service-item">
                        <a href="{{ route('home.search.projects', ['query' => $item->search_term ]) }}">
                            {{ $item->search_term }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="services-suggestions">
        <h6>Popular Searches</h6>
        <ul>
            @foreach ($search_terms as $item)
                
                <li class="suggestion-service-item">
                    <a href="{{ route('home.search.projects', ['query' => $item->search_term ]) }}">
                        {{ $item->search_term }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="services-suggestions">
        <h6>Services</h6>
        <ul>
            @foreach ($services as $item)
                
                <li class="suggestion-service-item">
                    <a href="{{ route('home.search.projects', ['query' => $item ]) }}">
                        {{ $item }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

@else
    <div class="">
        <p class="text-danger">{{ __('Nothing found') }}</p>
    </div>
@endif
