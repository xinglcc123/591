@extends('layouts.arvin591')

@section('body01')
<div>
    <p>test</p>
</div>
<button class="bg-green-500 active:bg-green-700">
<input class="focus:ring-2 focus:ring-blue-600">
  Click me
</button>
<div class="chat-notification">
  <div class="chat-notification-logo-wrapper">
    <img class="chat-notification-logo" src="/img/logo.svg" alt="ChitChat Logo">
  </div>
  <div class="chat-notification-content">
    <h4 class="chat-notification-title">ChitChat</h4>
    <p class="chat-notification-message">You have a new message!</p>
  </div>
</div>
<div class="rg_center">
    <!-- 定义表单 form -->
    <form action="#" method="post">
        <!-- 定义一个表格 -->
        <table>
            <!-- 表格第一行有两个单元格：用户名 + 输入用户名信息区域 -->
            <tr>
                <!-- 定义一个标签：用户名 -->
                <td class="text-cyan-600"><label for="username">用户名</label></td>
                <!-- 定义输入用户名信息的框框 -->
                <td class="td_right"><input type="text" name="username" id="username" placeholder="请输入用户名"></td>
                <span id="s_username" class="error"></span>
            </tr>

            <!-- 表格第二行有两个单元格：密码 + 输入密码区域 -->
            <tr>
                <!-- 定义一个标签：密码 -->
                <td class="td_left"><label for="password">密码</label></td>
                <!-- 定义输入密码的框框 -->
                <td class="td_right"><input type="password" name="password" id="password" placeholder="请输入密码"></td>
                <span id="s_password" class="error"></span>
            </tr>

            <!-- 表格第三行有两个单元格：邮箱 + 输入邮箱区域 -->
            <tr>
                <!-- 定义一个标签：邮箱 -->
                <td class="td_left"><label for="email">Email</label></td>
                <!-- 定义输入邮箱的框框 -->
                <td class="td_right"><input type="email" name="email" id="email" placeholder="请输入邮箱"></td>
            </tr>

            <!-- 表格第八行有一个单元格：注册按钮 -->
            <tr>
                <!-- 定义一个提交按钮 -->
                <td colspan="2" align="center"><input type="submit" id="btn_sub" value="注册"></td>
            </tr>
        </table>
    </form>
</div>
<!-- 右边部分 -->
<div class="rg_right ">
    <p>沒有帳號<a href="#">新用户注册</a></p>
</div>

@endsection