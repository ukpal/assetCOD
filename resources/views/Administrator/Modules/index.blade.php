@extends('Administrator.master')
<title>{{ $title }}</title>

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Modules</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Modules</li>
                        {{-- <li class="breadcrumb-item active">Modules = {{App\Models\Module::count();}}</li> --}}
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <!-- <h3 class="card-title"></h3> -->
                            <div class="row mx-0 justify-content-between ">
                                <div class="col-md-2 d-flex align-items-stretch">
                                    <a href="{{route('create.module')}}" class="btn btn-primary p-2"><i class="fas fa-plus"></i> Add New Module</a>
                                </div>
                                <div class="col-md-5 d-flex align-items-stretch ">
                                    @include('Administrator.notification')
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 50px">SL No.</th>
                                        <th style="width: 25%">Module Title</th>
                                        <th>Module Description</th>
                                        <th style="width: 80px"> Status</th>
                                        <th style="width: 80px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count =1; @endphp
                                    @foreach($modules as $module)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{$module->title}}</td>
                                        <td>{!! Str::limit($module->description, 40, ' ...') !!}</td>
                                        <td>
                                            <input data-id="{{$module->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $module->status ? 'checked' : '' }}>
                                        </td>

                                        <td>
                                            <a href="{{route('edit.module',$module->id)}}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

@section('ajaxStatus')
<script>
    $(function() {
        $('.toggle-class').change(function() {
            const path = "{{route('update.status')}}";
            var status = $(this).prop('checked') == true ? 1 : 0;
            var module_id = $(this).data('id');
            // console.log(status);
            // console.log(module_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: path,
                data: {
                    'status': status,
                    'module_id': module_id
                },
                success: function(data) {
                    //   console.log(data.success)
                    swal(data.success);

                },
                error: function(data) {
                    swal(data.error);
                }
            });
        })
    })
</script>
@endsection
