<x-validation.error/>
<table class="DataTable_activation">
    <thead>
    <tr>
        <th class="no-sort">
            <div class="mark-all-checkbox">
                <input type="checkbox" class="all-checkbox">
            </div>
        </th>
        <th>{{__('ID')}}</th>
        <th>{{__('Category Type')}}</th>
        <th>{{__('Short Description')}}</th>
        <th>{{__('Category')}}</th>
        <th>{{__('Status')}}</th>
        <th>{{__('Image')}}</th>
        <th>{{__('Action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($all_categories_type as $sub_cat)
        <tr>
            <td> <x-bulk-action.bulk-delete-checkbox :id="$sub_cat->id"/> </td>
            <td>{{ $sub_cat->id }}</td>
            <td>{{ $sub_cat->name }}</td>
            <td>{{ $sub_cat->short_description }}</td>
            <td>{{ optional($sub_cat->category)->category }}</td>
            <td><x-status.table.active-inactive :status="$sub_cat->status"/></td>
            <td>
                <span class="img_50">
                    {!! render_image_markup_by_attachment_id($sub_cat->image); !!}
                </span>
                @php $sub_cat_img = get_attachment_image_by_id($sub_cat->image,null,true); @endphp
                @if (!empty($sub_cat_img))
                    @php  $img_url = $sub_cat_img['img_url']; @endphp
                @endif
            </td>
            <td>
                <x-status.table.select-action :title="__('Select Action')"/>
                <ul class="dropdown-menu status_dropdown__list">
                    @can('category-type-edit')
                    <li class="status_dropdown__item">
                        <a
                            class="btn dropdown-item status_dropdown__list__link edit_sub_category_modal"
                            data-bs-toggle="modal"
                            data-bs-target="#editSubCategoryModal"
                            data-id="{{ $sub_cat->id }}"
                            data-img_id="{{ $sub_cat->image }}"
                            data-img_url="{{ $img_url }}"
                            data-name="{{ $sub_cat->name }}"
                            data-short_description="{{ $sub_cat->short_description }}"
                            data-slug="{{ $sub_cat->slug }}"
                            data-category="{{ $sub_cat->category_id }}">
                            {{ __('Edit Category Type') }}
                        </a>
                    </li>
                    @endcan
                    @can('category-type-delete')
                    <li class="status_dropdown__item"><x-popup.delete-popup :title="__('Delete Category Type')" :url="route('admin.category-type.delete',$sub_cat->id)"/></li>
                    @endcan
                    @can('category-type-status-change')
                    <li class="status_dropdown__item"><x-status.table.status-change :title="__('Change Status')" :url="route('admin.category-type.status',$sub_cat->id)"/></li>
                    @endcan
                </ul>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<x-pagination.laravel-paginate :allData="$all_categories_type"/>
