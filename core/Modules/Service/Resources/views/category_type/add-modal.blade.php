<!-- Sub Category Edit Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('Add New Category Type') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('admin.category-type.all')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <x-validation.error/>
                    <x-form.text :title="__('Category Type')" :type="__('text')" :name="'name'" :id="'name'" :value="old('name', '')" :placeholder="__('Enter Category Type')"/>
                    <x-form.slug :name="'slug'" :id="'slug'"/>
                    <x-form.textarea :title="__('Short Description')" :name="'short_description'" :id="'short_description'" :value="old('short_description', '')" :placeholder="__('Max 190 character')"/>
                    <x-form.category-dropdown :title="__('Select Category')" :name="'category'" :id="'category'" :class="'form-control category_select2'" />
                    <x-form.active-inactive :title="__('Select Status')" :info="__('If you select inactive the services will off for the category')" />
                    <x-backend.image :title="__('')" :name="'image'" :dimentions="__('3000x300(optional)')"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline-owrners" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <x-btn.submit :title="__('Save')" :class="'btn-gradient add_subcategory'" />
                </div>
            </form>
        </div>
    </div>
</div>
