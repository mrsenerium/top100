@if (session('status'))
<div class="alert alert-{{session('status')['type']}} alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {!! session('status')['message'] !!}
</div>
@endif
