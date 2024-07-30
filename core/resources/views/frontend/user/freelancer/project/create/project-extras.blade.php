<!-- Gig Introduction Start -->
<div class="setup-wrapper-contents">
    <div class="create-project-wrapper-item">
        <div class="create-project-wrapper-item-top profile-border-bottom">
            <h4 class="create-project-wrapper-title">{{ __('Add Extras') }}</h4>
        </div>
        <div class="create-project-intro-contents">
            <div class="create-project-intro-contents-form custom-form">
                <div class="my-2">
                    <button class="btn btn-primary" id="add-extra-btn" type="button">
                        <i class="fas fa-plus"></i>
                        Add Extra
                    </button>
                </div>

                <div id="project-extras-container" class="row">
                    <div class="col-lg-6 col-md-12 col-12 project-extra-parent">
                        <div class="project-extra">
                            <div class="row align-items-center">
                                <div class="col-6 col-lg-4">
                                    <x-form.text :type="'text'" :id="'extras_title'" :name="'extras_title[]'" :divClass="'mb-0'" :class="'form--control'" :value="old('extras_title[]')" :placeholder="__('Name')" />
                                </div>
                                <div class="col-6 col-lg-4">
                                    <div class="single-input mb-0">
                                        <label class="label-title" for="is_basic_standard_premium"></label>
                                        <select class="form--control" name="is_basic_standard_premium[]" id="">
                                            <option value="Basic">Basic</option>
                                            <option value="Standard">Standard</option>
                                            <option value="Premium">Premium</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-12 col-lg-4 d-flex align-items-center">
                                    <div class="col-8">
                                        <x-form.text :type="'number'" :id="'extras_price'" :name="'extras_price[]'" :divClass="'mb-0'" :class="'form--control'"  :placeholder="__('Price')" />
                                    </div>
                                    <div class="col-4 justify-content-end d-flex">
                                        <button class="btn btn-outline-danger rounded-circle delete-project-extra">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                </div>
                                <hr class="mt-3">
                                <div class="col-12">
                                    <div class="single-input mt-1">
                                        <label class="label-title" for="extras_description">Description</label>
                                        <textarea class="form--control" id="extras_description" name="extras_description[]"> </textarea>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>



        </div>
    </div>
</div>
<!-- Gig Introduction Ends -->