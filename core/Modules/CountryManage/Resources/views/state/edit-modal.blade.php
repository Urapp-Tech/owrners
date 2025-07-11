<!-- State Edit Modal -->
<div class="modal fade" id="editStateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('Edit State') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('admin.state.edit')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="state_id" id="state_id" value="">
                <div class="modal-body">
                    <x-form.text :title="__('State')" :type="__('text')" :name="'edit_state'" :id="'edit_state'" :placeholder="__('Enter state name')"/>
                    <div class="single-input">
                        <label class="label-title mt-3">{{ __('Select Country') }}</label>
                        <select name="edit_country" id="edit_country" class="form-control country_select22">
                            @foreach($all_countries as $data)
                                <option value="{{ $data->id }}">{{ $data->country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-form.timezone :title="__('Select Timezone')" :name="'edit_timezone'" :id="'edit_timezone'" :class="'form-control timezone_select2_edit'"  />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline-owrners" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <x-btn.submit :title="__('Update')" :class="'btn-gradient  edit_state'" />
                </div>
            </form>
        </div>
    </div>
</div>
