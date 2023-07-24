@if(session('success'))
<div id="toastsContainerTopRight" class="toasts-top-right fixed">
  <div class="toast bg-success fade show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      {{-- <strong class="mr-auto">Toast Title</strong> --}}
      <h5 class="mr-auto">Success</h5>
      {{-- <small>Subtitle</small> --}}
      <button data-dismiss="toast" type="button" class="ml-2 mb-1 close" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
    <div class="toast-body">{{session('success')}}</div>
  </div>
</div>
@elseif(session('error'))
{{-- <div class="alert alert-danger alert-dismissible fade show p-2 mb-0 w-100" id="alert" role="alert">
<h5 class="mb-1">{{session('error')}}</h5>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div> --}}
<div id="toastsContainerTopRight" class="toasts-top-right fixed">
  <div class="toast bg-danger fade show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      {{-- <strong class="mr-auto">Toast Title</strong> --}}
      <h5 class="mr-auto">Error</h5>
      {{-- <small>Subtitle</small> --}}
      <button data-dismiss="toast" type="button" class="ml-2 mb-1 close" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
    <div class="toast-body">{{session('error')}}</div>
  </div>
</div>

@endif

{{-- <div id="toastsContainerTopRight" class="toasts-top-right fixed">
  <div class="toast bg-success fade show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="mr-auto">Toast Title</strong>
      <small>Subtitle</small>
      <button data-dismiss="toast" type="button" class="ml-2 mb-1 close" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
    <div class="toast-body">Lorem ipsum dolor sit amet, consetetur sadipscing elitr.</div>
  </div>
</div> --}}
