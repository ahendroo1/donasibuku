@if ($paginator->lastPage() > 1)
<?php
    $linknya = Request::fullUrl();
    $linknya = explode('?', $linknya);
    $linknya = str_replace("page=".g('page'), "", $linknya);
?>
<div class="m-t-40">
    <ul class="pagination custom-paginate">
        <li class="pull-left {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
            <a href="{{ $paginator->url(1) }}&{{$linknya[1]}}" class="right-left-custom"><i class="fas fa-chevron-left"></i></a>
        </li>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                <a href="{{ $paginator->url($i) }}&{{$linknya[1]}}" class="custom-number">{{ $i }}</a>
            </li>
        @endfor
        <li class="pull-right {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
            <a href="{{ $paginator->url($paginator->currentPage()+1) }}&{{$linknya[1]}}" class="right-left-custom right-custom-button"><i class="fas fa-chevron-right"></i></a>
        </li>
    </ul>
</div>
@endif