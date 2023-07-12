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
                        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('pushService.create') }}">{{ ___('pushService.new_push_service') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ ___('common.add_new') }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}
        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route(@$data['route']) }}" enctype="multipart/form-data" method="post" id="visitForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('pushService.subject') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('subject') is-invalid @enderror" name="subject"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('pushService.enter_subject') }}" value="{{ old('subject') }}">
                                    @error('subject')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('pushService.description') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('description') is-invalid @enderror" name="description"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('pushService.enter_description') }}" value="{{ old('description') }}">
                                    @error('description')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('pushService.image') }} <span
                                        class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('image') is-invalid @enderror" type="file" name="image"
                                        list="datalistOptions" id="exampleDataList">
                                    @error('image')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="validationServer04" class="form-label">{{ ___('pushService.receiver_type') }} <span class="fillable">*</span></label>
                                    <select class="nice-select niceSelect bordered_style wide @error('receiver_type') is-invalid @enderror"
                                    name="receiver_type" id="receiver_type"
                                    aria-describedby="validationServer04Feedback">
                                        <option value="role" {{ old('receiver_type')=='role'? 'selected':'' }}>{{ ___('pushService.role') }}</option>
                                        <option value="user" {{ old('receiver_type')=='user'? 'selected':'' }}>{{ ___('pushService.user') }}</option>
                                    </select>
                                    @error('receiver_type')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3" id="role_selector">
                                    <label for="validationServer04" class="form-label">{{ ___('pushService.roles') }} <span class="fillable">*</span></label>
                                    <select class="nice-select niceSelect bordered_style wide @error('role') is-invalid @enderror"
                                    name="role" id="validationServer04"
                                    aria-describedby="validationServer04Feedback">
                                    @foreach (@$data['roles'] as $role)
                                        <option value="{{ $role->id }}" {{ old('role')==$role->id ? 'selected':'' }}>{{ $role->name }}</option>
                                    @endforeach
                                    </select>
                                    @error('role')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3" id="user_selector">
                                    <label for="validationServer04" class="form-label">{{ ___('pushService.users') }} <span class="fillable">*</span></label>
                                    <select class="nice-select niceSelect bordered_style wide @error('user') is-invalid @enderror" name="user"
                                    aria-describedby="validationServer04Feedback">
                                    @foreach (@$data['users'] as $user)
                                        <option value="{{ $user->id }}" {{ old('user')==$user->id ? 'selected':'' }}>{{ $user->name }} - {{ $user->email }}</option>
                                    @endforeach
                                    </select>
                                    @error('user')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('pushService.type') }} <span class="fillable">*</span></label>
                                    <select class="nice-select niceSelect bordered_style wide @error('type') is-invalid @enderror" name="type"
                                    aria-describedby="validationServer04Feedback">
                                    @foreach (@$data['notification_types'] as $type)
                                        <option value="{{ $type }}" {{ old('type')==$type ? 'selected':'' }}>{{ $type }}</option>
                                    @endforeach
                                    </select>
                                    @error('type')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12 mt-24">
                            <div class="text-end">
                                <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                    </span>{{ ___('common.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#user_selector').hide();
        })

        $('#receiver_type').on('change', function () {
            if ($(this).val() == 'role') {
                $('#role_selector').show();
                $('#user_selector').hide();
            }else {
                $('#user_selector').show();
                $('#role_selector').hide();
            }
        })
    </script>
@endsection
