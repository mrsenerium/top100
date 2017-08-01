<div>
    Showing
    @if($collection->count() < 10)
    {{($collection->total() - $collection->count()) + 1}}
    through
    {{$collection->total()}}
    @else
    {{($collection->currentPage() * $collection->count()) - $collection->count() + 1}} through
    {{$collection->currentPage() * $collection->count()}}
    @endif
    out of
    {{$collection->total()}}
</div>
<div class="hidden-xs">
    {!! $collection->links() !!}
</div>
<div class="visible-xs-block">
    <nav>
      <ul class="pager">
        @if($collection->currentPage() > 1)
        <li><a href="{{$collection->previousPageUrl()}}">Previous</a></li>
        @endif
        @if($collection->hasMorePages())
        <li><a href="{{$collection->nextPageUrl()}}">Next</a></li>
        @endif
      </ul>
    </nav>
</div>
