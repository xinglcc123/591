@extends('layouts.arvin591Manage')
<!-- //API格式 頁面不會刷新 -->
@section('body03')
<div class="container">
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

@section('index01')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-11">
            <!-- 表單 form -->
            <form action="#" method="post">
                <!-- CSRF 保護 -->
                <!-- {{ csrf_field() }} -->
                <!-- 表格 table -->
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col-1">後台頁面</th>
                        </tr>
                    </thead>
                    <tr>
                        <th>搜尋：</th>
                        <td class="td_right"><input type="text" name="title" id="title" placeholder="關鍵字" value=""></td>
                    </tr>
                    <tr scope="row">
                        <th scope="col-1">金額：</th>
                        <td><input type="checkbox" name="price" id="price" value="0,5000">0~5000</td>
                        <td><input type="checkbox" name="price" id="price" value="5000,10000">5000~10000</td>
                        <td><input type="checkbox" name="price" id="price" value="10000,15000">10000~15000</td>
                        <td><input type="checkbox" name="price" id="price" value="15000,20000">15000~20000</td>
                        <td>最低金額：<input type="text" name="priceMin" id="priceMin" placeholder="金額" value=""></td>
                        <td>最大金額：<input type="text" name="priceMax" id="priceMax" placeholder="金額" value=""></td>
                    </tr>
                    <tr>
                        <th>刊登身分</th>
                        <td><input type="radio" name="role_name" id="role_name" value="屋主">屋主</td>
                        <td><input type="radio" name="role_name" id="role_name" value="代理人">代理人</td>
                        <td><input type="radio" name="role_name" id="role_name" value="仲介">仲介</td>
                    </tr>
                    <tr>
                        <th></th>
                        <td><input class="btn btn-primary" id="postForm" type="button" value="傳送" onClick="getManage()" /></td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
@endsection

@section('body01')
<div id="body01" class="col-xl">
</div>
@endsection