@extends('layouts.arvin591')

@section('body01')
<div class="container">
    <div class="row">
        <div class="col-xl">
            <form action="#" method="post">
                <!-- CSRF 保護 -->
                {{ csrf_field() }}
                <!-- 表格 table -->
                <table class="table">
                    <tr scope="row">
                        <th>註冊身分</th>
                        <td><input type="radio" name="identity" id="identity" value="會員" checked>會員</td>
                        <td><input type="radio" name="identity" id="identity" value="管理員">管理員</td>
                    </tr>
                    <tr>
                        <th>帳號：</th>
                        <td class="td_right"><input type="text" name="account" id="account" placeholder="輸入帳號" value=""></td>
                    </tr>
                    <tr>
                        <th>密碼：</th>
                        <td class="td_right"><input type="password" name="password" id="password" placeholder="輸入密碼" value=""></td>
                    </tr>
                    <tr>
                        <td><input class="btn btn-primary" id="logingo" type="button" value="登入" onClick="ajaxLogin()" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
@endsection