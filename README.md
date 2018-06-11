# 微信授权登录代理转发

### 功能描述

##### 代理微信授权登录（获取code或获取access_token及openid）并转发至请求源

### 安装使用

1. 将本项目部署到代理服务器，需要php环境，并重启web服务器。
2. 使用一个新域名（如：oauth.xx.com）解析到服务器ip，此域名将作为微信授权登录的回调域名
3. 请求地址（get/post）：http://oauth.xx.com/index.php <br/>
   请求参数：<br/>
   | 参数 | 解释 | 是否必须 | 备注 |
   | ------ | ------ | ----- | ----- |
   | app_id | 公众号id|   是   |       |
   | scope  | 微信登录授权作用域 |是|可选值："snsapi_base"或"snsapi_userinfo"|
   | redirect_uri | 授权回调地址 | 是 | 一般为发起授权登录的请求地址，需要用urlencode处理 |
   | proxy_scope | 代理操作作用域，用于判断获取code还是access_token|否|可选值："code"或"access_token"，默认"code"|
   | app_secret | 公众号密钥 |否|若proxy_scope为access_token,则此参数也需要|
   | oauth_type | 授权类型，判断是微信公众号授权还是开放平台网页授权 |否| 可选值:1或2，默认1|
   | state | 重定向参数 | 否 |   |
4. 根据请求地址及参数发起请求即可获取授权登录所需的code。

### 举例说明

* 获取code

1. 代理项目地址为"http://oauth.xx.com/index.php"
2. 首先必须将公众号授权回调域名设置为"oauth.xx.com"
3. 在"http://request.xx.com/index.php"页面内请求代理地址："http://oauth.xx.com/index.php?app_id=APPID&scope=SCOPE&redirect_uri=REDIRECT_URI"
4. 正常情况下最终将跳转到"http://request.xx.com/index.php?code=CODE&state=STATE"
5. 获取到code之后，后续获取access_token、获取用户信息即可

* 获取access_token

1. 代理项目地址为"http://oauth.xx.com/index.php"
2. 首先必须将公众号授权回调域名设置为"oauth.xx.com"
3. 在"http://request.xx.com/index.php"页面内请求代理地址："http://oauth.xx.com/index.php?app_id=APPID&scope=SCOPE&proxy_scope=access_token&app_secret=APPSECRET&redirect_uri=REDIRECT_URI"
4. 正常情况下最终将跳转到"http://request.xx.com/index.php?access_token=ACCESS_TOKEN&openid=OPENID"
5. 后续用access_token及openid获取用户信息即可


### 其它说明

* 本项目中的access_token与微信基础接口调用凭据的access_token无关，仅用于微信授权登录使用。
* 若仅获取code，强烈建议将access_token返回数据单独缓存，方便多个项目请求获取。
* 若获取access_token，则无需再对access_token返回数据单独缓存。另外，若部署在Linux服务器，由于需要创建缓存目录及文件，所以项目需要修改权限。其他，php环境需要开启session、cookie。