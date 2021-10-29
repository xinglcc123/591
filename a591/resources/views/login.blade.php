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
                        <th>帳號：</th>
                        <td class="td_right"><input type="text" name="account" id="account" placeholder="輸入帳號" value=""></td>
                    </tr>
                    <tr>
                        <th>密碼：</th>
                        <td class="td_right"><input type="text" name="password" id="password" placeholder="輸入密碼" value=""></td>
                    </tr>
                    <tr>
                        <td><input class="btn btn-primary" id="login" type="button" value="登入" onClick="login()" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
@endsection