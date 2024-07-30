<div class="shop-sidebar-content">
    <div class="shop-close-content">
        <div class="shop-close-content-icon"> <i class="fas fa-times"></i> </div>
        <div class="row">

            <div class="col-md-6">
                {{-- <div class="col-md-8 col-12 position-relative">
                    <input type="text" id="search" class="form-control searchbar-input search-in-subcategories" placeholder="Search">
                    <div class="searchbar-icon-subcategories">
                        <img src="{{ asset('assets/static/icons/search-magnifying.svg') }}" alt="">
                    </div>

                </div> --}}
            </div>
            <div class="col-md-6 row">

                <div class="col-md-3 col-12 filters-select mt-3 mt-md-0 pe-0">
                    <x-form.filter-project-job-country :innerTitle="__('Country')" :name="'country'" :id="'country'" />
                </div>
                <div class="col-md-3 col-12 filters-select mt-3 mt-md-0 filters-select-level pe-0">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="freelance-level" data-bs-toggle="dropdown" aria-expanded="false">
                            Level
                            <i class="fas fa-chevron-down ms-2"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="freelance-level">
                            <li><button class="dropdown-item" onclick="changeLevel('');" data-value="" type="button">{{ __('All') }}</button></li>
                            <li><button class="dropdown-item" onclick="changeLevel('junior');" data-value="junior" type="button">{{ __('Junior') }}</button></li>
                            <li><button class="dropdown-item" onclick="changeLevel('midLevel');" data-value="midLevel" type="button">{{ __('MidLevel') }}</button></li>
                            <li><button class="dropdown-item" onclick="changeLevel('senior');" data-value="senior" type="button">{{ __('Senior') }}</button></li>
                            <li><button class="dropdown-item" onclick="changeLevel('not mandatory');" data-value="not mandatory" type="button">{{ __('Not Mandatory') }}</button></li>
                        </ul>
                    </div>
                    <input type="hidden" id="level" name="level">
                </div>

                <div class="col-md-3 col-12 filters-select filters-select-star mt-3 mt-md-0 pe-0">

                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="rating-level" data-bs-toggle="dropdown" aria-expanded="false">
                            Ratings
                            <i class="fas fa-chevron-down ms-2"></i>
                        </button>
                        <ul class="dropdown-menu text-primary" aria-labelledby="rating-level">
                            <li><button class="dropdown-item" onclick="changeRating('');" data-value="" type="button">All</button></li>
                            <li>
                                <button class="dropdown-item" onclick="changeRating('5');" data-value="junior" type="button">
                                    <a href="javascript:void(0)"> <i class="fas fa-star"></i> </a>
                                    <a href="javascript:void(0)"> <i class="fas fa-star"></i> </a>
                                    <a href="javascript:void(0)"> <i class="fas fa-star"></i> </a>
                                    <a href="javascript:void(0)"> <i class="fas fa-star"></i> </a>
                                    <a href="javascript:void(0)"> <i class="fas fa-star"></i> </a>
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item" onclick="changeRating('4');" data-value="junior" type="button">
                                    <a href="javascript:void(0)"> <i class="fas fa-star"></i> </a>
                                    <a href="javascript:void(0)"> <i class="fas fa-star"></i> </a>
                                    <a href="javascript:void(0)"> <i class="fas fa-star"></i> </a>
                                    <a href="javascript:void(0)"> <i class="fas fa-star"></i> </a>
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item" onclick="changeRating('3');" data-value="junior" type="button">
                                    <a href="javascript:void(0)"> <i class="fas fa-star"></i> </a>
                                    <a href="javascript:void(0)"> <i class="fas fa-star"></i> </a>
                                    <a href="javascript:void(0)"> <i class="fas fa-star"></i> </a>
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item" onclick="changeRating('2');" data-value="junior" type="button">
                                    <a href="javascript:void(0)"> <i class="fas fa-star"></i> </a>
                                    <a href="javascript:void(0)"> <i class="fas fa-star"></i> </a>
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item" onclick="changeRating('1');" data-value="junior" type="button">
                                    <a href="javascript:void(0)"> <i class="fas fa-star"></i> </a>
                                </button>
                            </li>
                        </ul>
                    </div>
                    <input type="hidden" id="ratings" name="ratings">

                   
                </div>

                <div class="col-md-3 col-12 filters-select mt-3 mt-md-0 align-content-center pe-0">
                    <a href="javascript:void(0)" class="single-shop-left-filter-reset col-md-3 col-12 " id="subcategory_project_filter_reset">{{ __('Reset Filter') }}</a>
                </div>



            </div>
        </div>

    </div>
</div>