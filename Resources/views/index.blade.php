@extends('pushservice::layouts.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <div class="page-content">

        {{-- bradecrumb Area S t a r t --}}
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="bradecrumb-title mb-1">{{ $data['title'] }}</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('common.home') }}</a></li>
                            <li class="breadcrumb-item">{{ $data['title'] }}</li>
                        </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <!--  table content start -->
        <div class="table-content table-basic mt-20">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $data['title'] }}</h4>

                    <div class="searchbox">
                        <div class="pagewise-search-div">
                            <i class="las la-search"></i>
                            <input name="search" class="pagewise-search" value="{{request()->input('search') }} " type="text" placeholder="Search " id="pagewiseSearch" onchange="tableSearch()">
                        </div>
                    </div>

                    @if (hasPermission(@$data['create']['permission']))
                            <a href="{{ route($data['create']['route']) }}" class="btn btn-lg ot-btn-primary">
                                <span><i class="fa-solid fa-plus"></i> </span>
                                <span class="">{{ $data['create']['title'] }}</span>
                            </a>
                    @endif

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered role-table">
                            <thead class="thead">


                                <tr>
                                    <th class="serial">{{ ___('common.sr_no') }}</th>
                                    <th class="purchase">{{ ___('pushService.subject') }}</th>
                                    <th class="purchase">{{ ___('pushService.description') }}</th>
                                    <th class="purchase">{{ ___('pushService.image') }}</th>
                                    <th class="purchase">{{ ___('pushService.receiver') }}</th>
                                    @if (hasPermission(@$data['actions']['delete']['permission']))
                                        <th class="action">{{ ___('common.action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['items'] as $key => $row)
                                    <tr id="row_{{ $row->id }}">
                                        <td class="serial">{{ ++$key }}</td>

                                        <td>{{ @$row->subject }}</td>
                                        <td>{{ $row->description }}</td>
                                        <td>
                                            <img src="{{ @$row->image }}" alt="" width="80">
                                        </td>
                                        <td>{{ $row->pushable_type }} <br> {{ $row->pushable_id }}</td>


                                        @if (hasPermission('push_service_delete'))
                                            <td class="action">
                                                <div class="dropdown dropdown-action">
                                                    <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end ">
                                                        @foreach ($data['actions'] as $key=>$item)
                                                            @if (hasPermission($item['permission']))
                                                                @if ($key == 'delete')
                                                                    <li>
                                                                        <a class="dropdown-item" href="javascript:void(0);"
                                                                        onclick="delete_row('{{ $item['url'] }}', {{ $row->id }})">
                                                                            <span class="icon mr-12"><i
                                                                                    class="fa-solid fa-trash-can"></i></span>
                                                                            <span>{{ $item['title'] }}</span>
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center gray-color">
                                            <img src="{{ asset('images/no_data.svg') }}" alt="" class="mb-primary"
                                                width="100">
                                            <p class="mb-0 text-center">No data available</p>
                                            <p class="mb-0 text-center text-secondary font-size-90">
                                                Please add new entity regarding this table</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!--  table end -->
                    <!--  pagination start -->



                    <div class="ot-pagination pagination-content d-flex justify-content-end align-content-center py-3">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-between">
                                {{$data['items']->links("pagination::bootstrap-4")}}
                            </ul>
                        </nav>
                    </div>

                    <!--  pagination end -->
                </div>
            </div>
        </div>
        <!--  table content end -->

    </div>
@endsection

@push('script')
    @include('pushservice::partials.delete-ajax')
@endpush
