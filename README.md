# 微信授权登录代理转发

### 功能描述

##### 代理微信授权登录（获取code参数）并转发至请求源

### 安装使用

1. 将本项目部署到代理服务器，需要php环境，并重启web服务器。
2. 使用一个新域名（如：oauth.xx.com）解析到服务器ip，此域名将作为微信授权登录的回调域名
3. 请求地址（get/post）：http://oauth.xx.com/index.php 
   请求参数：
   | 参数 | 解释 | 默认值 | 备注 |
   | ------ | ------ | ----- | ----- |
   | app_id | 公众号id |      |  必填     |
   | scope  | 微信登录授权作用域 | |  必填 “snsapi_base”或“snsapi_userinfo”   |
   | app_secret | 公众号密钥 | | 选填，暂无用 |
   | oauth_type | 授权类型 | 1 | 选填，1：公众号授权 2：开放平台网页授权 |
   | state | 重定向参数 | 系统随机生成 | 选填 |
4. 根据请求地址及参数发起请求即可获取授权登录所需的code。

### 举例说明

1. 代理项目地址为"http://oauth.xx.com/index.php"
2. 首先必须将公众号授权回调域名设置为"oauth.xx.com"
3. 在"http://request.xx.com/index.php"页面内请求代理地址："http://oauth.xx.com/index.php?appid=APPID&scope=SCOPE"
4. 正常情况下最终将跳转到"http://request.xx.com/index.php?code=CODE&state=STATE"
5. 获取到code之后，后续获取access_token、获取用户信息即可

### 其它说明

##### 若同一公众号授权登录的接口由多个域名使用，强烈建议将授权登录的access_token单独缓存，方便多个项目请求获取。