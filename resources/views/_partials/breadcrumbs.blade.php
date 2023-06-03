@if (isset($breadcrumbs))
<ol class="breadcrumb breadcrumb-custom">
    <li class="text"> {!! Lang::get('lang.you_are_here') !!} :</li>

    <?php //dd(count($breadcrumbs)); ?>

    @foreach($breadcrumbs as $key => $breadcrumb)
    @if ($key < count($breadcrumbs) - 1)
    <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
    @else
    <li class="text">{{ $breadcrumb->title }}</li>
    @endif
    @endforeach
</ol>
@endif
