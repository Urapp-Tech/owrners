<script>
    (function ($) {
        "use strict";
        $(document).ready(function () {
            let site_default_currency_symbol = '{{ site_currency_symbol() }}';
            

            //get type and calculate transaction fee
            $(document).on('click','.order_options_modal_btn',function(){
                let type = $('.project-preview-tab .tabs .active').text();
                let project_id = $(this).data('project_id');

                $('.set_basic_standard_premium_type').text(type);
                $('#project_id_for_order').val(project_id);
                $('#basic_standard_premium_type').val(type);

                let currentTab = $('.project-preview-tab .tabs .active').attr("data-tab");
                let price = $(`#${currentTab} .project-preview-tab-inner-item .price span`).text();
                let new_price = price.substring(1);
                let remove_comma_fron_new_price = new_price.replace(/\,/g,'')
                let float_price = parseFloat(remove_comma_fron_new_price);

                $('#order-options-plan-type').html(type);
                $('#order-options-price').html(site_default_currency_symbol + ' ' + new_price);

                $('.order-options-extra').show();
                $('.order-options-extra:not([data-type="'+type.trim()+'"])').hide();

            });

            $(document).on('change', '.orders-extras-check-input', function () {
                let extras = [];
                let extras_price = 0;
                $('.orders-extras-check-input:checked').each(function (i, e) {
                    extras.push($(e).val());
                    extras_price += $(e).attr('data-extra-price');
                })
                $('#order_extras').val(extras.join(','));
                $('#order_extras_price').val(extras_price);
            })

        });
    }(jQuery));

   
</script>
