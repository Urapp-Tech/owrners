<div class="custom_table style-06 table-rounded-rows px-4">
    <table>
        <thead>
            <tr>
                 <th>Gig Name</th>
                 <th>Clicks</th>
                 <th>Impressions</th>
                 <th>Orders</th>
                 <th>Gig Category</th>
                 <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
                <tr>
                    <td>
                        <div class="d-flex">
                            <div class="project_photo_preview_container">
                                @if($project->image)
                                    <img src="{{ asset('assets/uploads/project/'.$project->image) }}" alt="{{ __('Gig Image') }}" class="project_photo_preview">
                                @endif
                            </div>
                            <div class="align-content-center px-3">
                                {{ $project->title }}
                            </div>
                        </div>
                    </td>
                    <td>{{ $project->clicks_count }}</td>
                    <td>{{ $project->impressions_count }}</td>
                    <td>{{ $project->orders_count }}</td>
                    <td>{{ $project->project_category->category }}</td>
                    <td>
                        <div class="d-flex mx-3">
                            <a class="mx-2" href="{{ route('freelancer.project.details',[ 'username'=> $project?->project_creator?->username , 'slug'=> $project->slug ]) }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('freelancer.project.edit', $project->id) }}">
                                <i class="fas fa-pen"></i>
                            </a>
                            @if($project?->orders_count == 0)
                                <a href="javascript:void(0)" class=" delete_project mx-2" data-project-id="{{ $project->id }}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
<x-pagination.laravel-paginate :allData="$projects" />