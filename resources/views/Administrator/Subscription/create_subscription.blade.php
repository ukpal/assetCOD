@extends('Administrator.master')
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
                        <li class="breadcrumb-item active">Create Subscription Plans</li>
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
                            <div class="row mx-0">
                                <div class="col-md-10">
                                    @include('Administrator.notification')
                                </div>
                                <div class="col-md-2">
                                    <a href="{{url('admin/subscription')}}" class="btn btn-primary float-right"><i class="fas fa-backward"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            {{-- create form --}}
                            <form action="{{url('admin/subscription/store')}}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="title">Plan Name <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Enter plan name" value="{{ old('title') }}">
                                        @error('title')
                                            <small class="text-danger" data-error='title'>{{ $message }}</small>
                                        @enderror

                                    </div>
                                    <div class="row mx-0">
                                        <div class="col-md-6 p-0 pr-2">
                                            <div class="form-group">
                                                <label for="tenure">Tenure (in year) <span class="text-danger">*</span></label>
                                                <input type="text" name="tenure" class="form-control @error('tenure') is-invalid @enderror" id="tenure" maxlength="4" placeholder="Enter plan tenure" value="{{ old('tenure') }}">
                                                @error('tenure')
                                                    <small class="text-danger" data-error='tenure'>{{ $message }}</small>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col-md-6 p-0 pl-2">
                                            <div class="form-group">
                                                <label for="amount">Amount <span class="text-danger">*</span></label>
                                                <input type="text" name="amount" class="form-control @error('amount') is-invalid @enderror" maxlength="6" id="amount" placeholder="Enter amount" value="{{ old('amount') }}">
                                                @error('amount')
                                                    <small class="text-danger"  data-error='amount'>{{ $message }}</small>
                                                @enderror

                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="desc">Plan Description</label>
                                        <textarea class="form-control" id="desc" rows="3" name="description" placeholder="Enter plan description">{{ old('description') }}</textarea>
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>


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

@section('module_script')
<script type="text/javascript">
    $(function () {
        $("[name='title']").on("focus",function(){
            $(this).alpha();
            $("[data-error='title']").html("");
            $(this).removeClass("is-invalid");
        });
        $("[name='tenure']").on("focus",function(){
            $(this).numeric();
            $("[data-error='tenure']").html("");
            $(this).removeClass("is-invalid");
        });
        $("[name='amount']").on("focus",function(){
            $(this).numeric();
            $("[data-error='amount']").html("");
            $(this).removeClass("is-invalid");
        });
    });
</script>
@endsection
