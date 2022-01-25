@extends('layouts.arvin591Manage')
<!-- //API格式 頁面不會刷新 -->

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
                            <th scope="col-1">後台-新增</th>
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
    <div class="row">
        <div class="col-xl-11">
            <!-- 表單 form -->
            <form action="#" id="ajaxAddImg" method="post">
                <!-- CSRF 保護 -->
                <!-- {{ csrf_field() }} -->
                <!-- 表格 table -->
                <table class="table">
                    <tr>
                        <th>標題：</th>
                        <td class="td_right"><input type="text" name="titleAdd" id="titleAdd" placeholder="標題" value="test"></td>
                    </tr>
                    <tr>
                        <th>金額：</th>
                        <td class="td_right"><input type="text" name="priceAdd" id="priceAdd" placeholder="金額" value="1000"></td>
                    </tr>
                    <tr>
                        <th>路段：</th>
                        <td class="td_right"><input type="text" name="communityAdd" id="communityAdd" placeholder="路段" value="test"></td>
                    </tr>
                    <tr>
                        <th>圖片</th>
                        <td class="td_right">
                            選擇檔案:<input type="file" name="myfile" id="myfile" accept="image/gif, image/jpeg, image/png" />
                            <img id="addImgShow" style="display: none;" src="#" />
                        </td>
                        <td class="col-1">
                            <input type="button" id="addImg" value="上傳檔案" onClick="ajaxAddImg()" />
                        </td>
                    </tr>
                    <tr>
                        <th>身份：</th>
                        <td class="td_right"><input type="text" name="role_nameAdd" id="role_nameAdd" placeholder="身份" value="test"></td>
                    </tr>
                    <tr>
                        <th>聯絡人：</th>
                        <td class="td_right"><input type="text" name="contactAdd" id="contactAdd" placeholder="聯絡人" value="test"></td>
                    </tr>
                    <tr>
                        <th>樓層：</th>
                        <td class="td_right"><input type="text" name="floor_strAdd" id="floor_strAdd" placeholder="樓層" value="test"></td>
                    </tr>
                    <tr>
                        <th>類型：</th>
                        <td class="td_right"><input type="text" name="kind_nameAdd" id="kind_nameAdd" placeholder="類型" value="test"></td>
                    </tr>
                    <tr>
                        <th>格局</th>
                        <td class="td_right"><input type="text" name="room_strAdd" id="room_strAdd" placeholder="格局" value="test"></td>
                    </tr>
                    <tr>
                        <td><input class="btn btn-primary" id="ajaxAddButton" type="button" value="新增" onClick="ajaxAdd()" /></td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
@endsection