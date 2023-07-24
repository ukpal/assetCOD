@extends('Administrator.master')
<title>{{ $title }}</title>
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1>General Form</h1> -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Create Company</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">

                <!-- left column -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row mx-0 justify-content-between ">
                                <div class="col-md-2 d-flex align-items-stretch">
                                    <a href="{{route('companies')}}" class="btn btn-primary p-2"><i class="fas fa-backward"></i> Back</a>
                                </div>
                                <div class="col-md-5 d-flex align-items-stretch ">
                                    @include('Administrator.notification')
                                </div>
                            </div>

                        </div>
                        <!-- /.card-header -->

                        <!-- form start -->
                        <form action="{{route('purchase')}}" method="POST">
                            @csrf
                            <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="first_name">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" maxlength="35" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}"  placeholder="Enter First Name">
                                    @error('first_name')
                                        <small class="text-danger" data-error='first_name'>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" maxlength="35" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}"  placeholder="Enter First Name">
                                    @error('last_name')
                                        <small class="text-danger" data-error='last_name'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Company Name <span class="text-danger">*</span></label>
                                    <input type="text" name="company_name" maxlength="35" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}"  placeholder="Enter company name">
                                    @error('company_name')
                                        <small class="text-danger" data-error='company_name'>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="email">Email Address<span class="text-danger">*</span></label>
                                    <input type="email" name="email" maxlength="35" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"  placeholder="Enter company Email">
                                    @error('email')
                                        <small class="text-danger" data-error='email'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="phone">Phone <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" maxlength="35" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"  placeholder="Enter Phone Number">
                                    @error('phone')
                                        <small class="text-danger" data-error='phone'>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="country">Country<span class="text-danger">*</span></label>
                                    <input type="text" name="country" maxlength="35" class="form-control @error('country') is-invalid @enderror" value="{{ old('country') }}"  placeholder="Enter Country">
                                    @error('country')
                                        <small class="text-danger" data-error='country'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="state">State<span class="text-danger">*</span></label>
                                    <input type="text" name="state" maxlength="35" class="form-control @error('state') is-invalid @enderror" value="{{ old('state') }}"  placeholder="Enter State">
                                    @error('state')
                                        <small class="text-danger" data-error='state'>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="city">City<span class="text-danger">*</span></label>
                                    <input type="text" name="city" maxlength="35" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}"  placeholder="Enter City">
                                    @error('city')
                                        <small class="text-danger" data-error='city'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="state">Subscription Package<span class="text-danger">*</span></label>
                                    <select name="subscription_id" class="form-control @error('subscription_id') is-invalid @enderror">
                                    <option value="" selected>-----Select-----</option>
                                    @foreach($subscriptions as $item)
                                    <option value="{{$item->subscription_id}}">{{$item->title}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <style>
                                    .select2-container .select2-selection--single {
                                        height: 37px;
                                    }
                                </style>
                                <div class="form-group col-md-6">
                                    <label>System Currency</label>
                                    <select class="form-control select2bs4" name="currency" style="width: 100%;">
                                        @foreach (GeneralHelper::getCurrencyList() as $item)
                                            <option value="{{$item['name'].'-'.$item['code'].'-'.$item['symbol']}}" {{$item['code']=='USD' ? 'selected':''}}>
                                                {{$item['symbol'].' ('.$item['code'].')'}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('new_com_scripts')
<script type="text/javascript">
    $(function () {
        $("[name='first_name']").on("focus",function(){
            $(this).alpha();
            $("[data-error='first_name']").html("");
            $(this).removeClass("is-invalid");
        });
        $("[name='last_name']").on("focus",function(){
            $(this).alpha();
            $("[data-error='last_name']").html("");
            $(this).removeClass("is-invalid");
        });
        $("[name='company_name']").on("focus",function(){
            $(this).alpha();
            $("[data-error='company_name']").html("");
            $(this).removeClass("is-invalid");
        });
        $("[name='email']").on("focus",function(){
            // $(this).alpha();
            $("[data-error='email']").html("");
            $(this).removeClass("is-invalid");
        });
        $("[name='phone']").on("focus",function(){
            $(this).numeric();
            $("[data-error='phone']").html("");
            $(this).removeClass("is-invalid");
        });
        $("[name='country']").on("focus",function(){
            $(this).alpha();
            $("[data-error='country']").html("");
            $(this).removeClass("is-invalid");
        });
        $("[name='state']").on("focus",function(){
            $(this).alpha();
            $("[data-error='state']").html("");
            $(this).removeClass("is-invalid");
        });
        $("[name='city']").on("focus",function(){
            $(this).alpha();
            $("[data-error='city']").html("");
            $(this).removeClass("is-invalid");
        });
    });
</script>
@endsection
