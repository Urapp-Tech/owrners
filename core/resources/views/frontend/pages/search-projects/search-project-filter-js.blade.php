<script>
    (function ($) {
        "use strict";
        $(document).ready(function () {
            $('.country_select2').select2();

            //star rating filter
            $(document).on('click', '.active-list .list', function() {

                let ratings = $(".active-list .list");
                ratings.each(function (){
                    $(this).removeClass('active');
                });
                $(this).addClass('active');
                projects();

            });

            //search by country
            $(document).on('keyup', '#search', function() {
                projects();
            });

            $(document).on('change', '#country , #level , #delivery_day, #ratings', function() {
                projects();
            });
            $(document).on('click', '#set_price_range', function() {
                projects();
            });

            // pagination
            $(document).on('click', '.pagination a', function(e){
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                projects(page);
            });

            function projects(page = 1){
                let country = $('#country').val();
                let level = $('#level').val();
                let min_price = $('#min_price').val();
                let max_price = $('#max_price').val();
                let delivery_day = $('#delivery_day').val();
                let search = $('#search').val();
                let get_pro_projects;
                let rating = $('#ratings').val();
                // let rating = $('.filter-lists .list.active').attr('data-rating');

                if($('#get_pro_projects').prop('checked')){
                    $('#get_pro_projects').val('1')
                    get_pro_projects = $('#get_pro_projects').val()
                }else{
                    $('#get_pro_projects').val('0')
                    get_pro_projects = $('#get_pro_projects').val()
                }

                $.ajax({
                    url:"{{ route('home.search.projects.filter').'?page='}}" + page,
                    method:'GET',
                    data:{country:country,level:level,min_price:min_price,max_price:max_price,delivery_day:delivery_day,rating:rating,get_pro_projects:get_pro_projects,search:search, query: $('#search_popular_searches').val() },
                    success:function(res){
                        if(res.status=='nothing'){
                            $('.search_subcategory_result').html(
                                `<div class="congratulation-area section-bg-2 pat-100 pab-100">
                                    <div class="container">
                                        <div class="congratulation-wrapper">
                                            <div class="congratulation-contents center-text">
                                                <div class="congratulation-contents-icon bg-danger wow  zoomIn animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">
                                                    <i class="fas fa-times"></i>
                                                </div>
                                                <h4 class="congratulation-contents-title"> {{ __('OPPS!') }} </h4>
                                                <p class="congratulation-contents-para">{{ __('Nothing') }} <strong>{{ __('Found') }}</strong> </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>`);
                        }else{
                            $('.search_subcategory_result').html(res);
                        }
                    }

                });
            }

            // filter reset
            $(document).on('click', '#subcategory_project_filter_reset', function(e){
                $('#country').val('').trigger('change');
                $('#level').val('');
                $('#min_price').val('');
                $('#max_price').val('');
                $('#search').val('');
                $('.active-list .list').removeClass('active');
                $('#ratings').val('');
                projects();
            });

            //get pro projects
            $(document).on('change', '#get_pro_projects', function(e){
                e.preventDefault();
                projects();
            });
        });
    }(jQuery));

    
    function changeLevel(selector) {
        $('#level').val(selector).trigger('change');
    }

    function changeRating(selector) {
        $('#ratings').val(selector).trigger('change');
    }

</script>