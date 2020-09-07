@extends('console.view.auth.layout')

@section('content')
    <fieldset class="layui-elem-field">
        <legend>登录</legend>

        <div class="layui-field-box">
            <form class="layui-form" action="" method="post">
                <div class="layui-form-item">
                    <label class="layui-form-label">用户名</label>
                    <div class="layui-input-block">
                        <input type="text" name="username" autocomplete="off" placeholder="请输入用户名" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">密 码</label>
                    <div class="layui-input-block">
                        <input type="password" name="password" placeholder="请输入密码" autocomplete="off"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">验证码</label>
                    <div class="layui-input-inline captcha-input">
                        <input type="text" name="captcha" placeholder="请输入验证码" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-word-aux">
                        <img src="//www.oschina.net/action/user/captcha?t=1599034020751" width="114">
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn">登 录</button>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>
@endsection
