@extends('Administrator.master')
<title>{{ $title }}</title>
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Subscription Plans</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Subscription Plans</li>
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
                <div class="col-md-3 d-flex align-items-stretch">
                  <a href="{{url('admin/subscription/new')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Subscription</a>                
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
                    <th>Sl No</th>
                    <th>Title</th>
                    <th>Tenure</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th style="width:25%">Description</th>                   
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php $count =1; @endphp
                  @foreach($datas as $data)
                  <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{$data->title}}</td>
                    <td>{{$data->tenure}} year</td>
                    <td>$ {{$data->amount}}</td>
                    <td>
                      {{-- {{$data->status==1 ? 'Active' : 'Inactive'}} --}}
                      <input data-id="{{$data->subscription_id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $data->status ? 'checked' : '' }}>
                    </td>
                    <td>{!! Str::limit($data->description, 40, ' ...') !!}</td>                 
                    <td>
                      <a href="{{url('admin/subscription/edit').'/'.$data->subscription_id}}" class="btn btn-success btn-sm" title="Edit">
                        <i class="far fa-edit"></i></a>
                      <a href="{{route('get-modulepermission',$data->subscription_id)}}" title="Set Module Permission" class="btn btn-primary btn-sm">
                        <i class="fas fa-tasks"></i></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <!-- <tfoot>
                  <tr>
                    <th>Rendering engine</th>
                    <th>Browser</th>
                    <th>Platform(s)</th>
                    <th>Engine version</th>
                    <th>CSS grade</th>
                  </tr>
                  </tfoot> -->
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
            const path = "{{route('subscription.update.status')}}";
            var status = $(this).prop('checked') == true ? 1 : 0;
            var subscription_id = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: path,
                data: {
                    'status': status,
                    'subscription_id': subscription_id
                },
                success: function(data) {
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