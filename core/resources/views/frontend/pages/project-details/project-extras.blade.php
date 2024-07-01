<div class="modal fade" id="orderOptionsModal" tabindex="-1" aria-labelledby="orderOptionsModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="orderOptionsModalLabel">Order options</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 id="order-options-plan-type" class="oo-title"></h3>
                </div>
                <div>
                    <h6 class="oo-sub" id="order-options-price"></h6>
                </div>
            </div>

            <hr class="my-3">

            @foreach ($project->extras as $extra)
                
                <div class="order-options-extra border-1 broder-primary p-2" data-type="{{ $extra->is_basic_standard_premium }}">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="oo-title">{{ $extra->name }}</h3>    
                        </div>
                        <div>
                            <div class="checkbox-inline">
                                <input type="checkbox" name="order-extras[]" value="{{ $extra->id }}" id="extra-{{ $extra->id }}" data-extra-price="{{ $extra->price }}" class="check-input orders-extras-check-input">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <p class="oo-sub">{{ $extra->description }}</p>
                    </div>
                    <h6 class="oo-sub mt-2">{{ site_currency_symbol() }} {{ $extra->price }}</h6>
                </div>
            @endforeach
            
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
          <button class="btn-gradient basic_standard_premium"
          data-project_id="{{ $project->id }}" data-bs-toggle="modal" data-bs-target="#paymentGatewayModal"><span>  {{ __('Continue to Order') }} </span></button>
        </div>
      </div>
    </div>
  </div>