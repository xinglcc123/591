@extends('layouts.arvin591')
<!-- //API格式 頁面不會刷新 -->
@section('body03')
<div class="text-center">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" name="getPage01"></a></li>
            <li class="page-item"><a class="page-link" name="getPage02">上頁</a></li>
            <li class="page-item"><a class="page-link" name="getPage03"></a></li>
            <li class="page-item"><a class="page-link" name="getPage04"></a></li>
            <li class="page-item"><a class="page-link" name="getPage05"></a></li>
            <li class="page-item"><a class="page-link" name="getPage06"></a></li>
            <li class="page-item"><a class="page-link" name="getPage07"></a></li>
            <li class="page-item"><a class="page-link" name="getPage08">下頁</a></li>
            <li class="page-item"><a class="page-link" name="getPage09"></a></li>
        </ul>
    </nav>
</div>
@endsection

@section('body02')
<div id="body02" class="col-sm">
</div>
@endsection

@section('body01')
<div id="body01" class="col-xl">
</div>
@endsection