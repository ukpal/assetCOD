@extends('Administrator.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Set Module Permissions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Set Module Permission</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            {{-- <h3 class="card-title">Bordered Table</h3> --}}
                            <a href="{{route('create.module')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Modules</a>
                            <a href="{{url('admin/subscription')}}" class="btn btn-primary float-right"><i class="fas fa-backward"></i> Back</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">Serial No.</th>
                                        <th>Module Name</th>
                                        <th>View</th>
                                        <th>Add</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                        <!-- <th style="width: 40px">Label</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count =1; @endphp
                                    @foreach($modules as $module)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{$module->title}}</td>
                                        <td>
                                            <input type="checkbox" name="view" module="{{$module->m_id}}" value="{{$module->view}}" {{$module->view ? 'checked':''}}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="add" module="{{$module->m_id}}" value="{{$module->add}}" {{$module->add ? 'checked':''}}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="edit" module="{{$module->m_id}}" value="{{$module->edit}}" {{$module->edit ? 'checked':''}}>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="delete" module="{{$module->m_id}}" value="{{$module->delete}}" {{$module->delete ? 'checked':''}}>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <!-- <tr>
                                        <td>2.</td>
                                        <td>Clean database</td>
                                        <td>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar bg-warning" style="width: 70%"></div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-warning">70%</span></td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Cron job running</td>
                                        <td>
                                            <div class="progress progress-xs progress-striped active">
                                                <div class="progress-bar bg-primary" style="width: 30%"></div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-primary">30%</span></td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Fix and squish bugs</td>
                                        <td>
                                            <div class="progress progress-xs progress-striped active">
                                                <div class="progress-bar bg-success" style="width: 90%"></div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-success">90%</span></td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        {{-- <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('module_script')
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('input[type="checkbox"]').click(function() {
            const module_id = $(this).attr('module');
            const name = $(this).attr('name');
            var value = $(this).val();
            value = (value == 0 || value == '') ? 1 : 0;
            var subscription_id = "{{ Request::segment(3) }}";
            const path = "{{url('/admin/set-modulepermission/')}}";
            // const path ="{{url('/admin/set-modulepermission/')}}"+"/"+ module_id+ "/"+ name+"/"+value ;
            $(this).val(value);
            // console.log(value);
            // window.location = path;
            $.ajax({
                    type: "POST",
                    url: path, // Route
                    data: {
                        checkbox_val: value,
                        module_id: module_id,
                        check_name: name,
                        subscription_id: subscription_id
                    },
                    // beforeSend: function() {
                    //     swal("Wait.......")
                    // }
                })
                .done(function(resp) {
                    // swal.close();
                    console.log(resp);
                    
                    swal({
                        title: "Permission Updated",
                        //   text: "You clicked the button!",
                        icon: "success",
                    });
                });
        });
    })
</script>

@endsection