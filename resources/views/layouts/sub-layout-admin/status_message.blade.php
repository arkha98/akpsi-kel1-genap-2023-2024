@if (session('sts_msg'))
    @if (session('sts_msg.status') == 1)
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ session('sts_msg.message') }}
    </div>
    @endif

    @if (session('sts_msg.status') == 0)
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ session('sts_msg.message') }}
    </div>
    @endif
@endif

{{-- <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
    Danger alert preview. This alert is dismissable. A wonderful serenity has taken possession of my
    entire
    soul, like these sweet mornings of spring which I enjoy with my whole heart.
  </div> --}}
