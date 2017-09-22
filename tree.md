#i_service目录结构
.  
├── application             `程序主目录`  
│   ├── controllers         `控制器目录`  
│   ├── library             `工具及类库目录`  
│   │   ├── auth            `验证类库`  
│   │   ├── cache           `缓存类库`  
│   │   ├── convertor       `转换器库`    
│   │   ├── dao             `数据层类库`  
│   │   ├── db              `数据库链接类库`  
│   │   ├── enum            `枚举类库`  
│   │   ├── interceptor     `拦截器类库`  
│   │   ├── log             `日志记录类库`  
│   │   ├── oss             `阿里云OSS储存`  
│   │   │   ├── conf        `OSS配置文件`  
│   │   │   └── lib         `OSS类库`  
│   │   ├── push            `推送类`  
│   │   │   └── umeng       `友盟推送类库`  
│   │   ├── rpc             `接口请求类库`  
│   │   └── util            `工具类库`  
│   ├── models              `模型层目录`  
│   └── plugins             `程序插件目录`  
├── env                     `配置文件目录`  
├── log                     `日志目录`  
└── www                     `入口目录`  

*******

#i_admin目录结构
.
├── application             `程序主目录`  
│   ├── controllers         `控制器目录`  
│   ├── library             `工具及类库目录`  
│   │   ├── auth            `验证类库`  
│   │   ├── cache           `缓存类库`  
│   │   ├── convertor       `转换器库`  
│   │   ├── enum            `枚举类库`  
│   │   ├── interceptor     `拦截器类库`  
│   │   ├── rpc             `接口请求类库`  
│   │   └── util            `工具类库`  
│   ├── models              `模型层目录`  
│   ├── plugins             `程序插件目录`  
│   └── views               `视图层目录`  
│       ├── admin           `总后台管理视图`  
│       ├── app             `APP管理视图`  
│       ├── common          `公共引用视图`  
│       ├── error           `异常视图`  
│       ├── group           `集团管理视图`  
│       ├── hotel           `物业管理视图`  
│       ├── index           `默认页视图`  
│       ├── login           `登录视图`  
│       ├── rss             `RSS管理视图`  
│       ├── system          `系统管理视图`  
│       └── user            `用户管理视图`  
├── env                     `配置文件目录`  
├── log                     `日志目录`  
└── www                     `入口目录`  
    └── assets              `静态资源目录`  
        ├── css             `层叠样式表资源目录`  
        ├── img             `图片资源目录`  
        │   └── icons       `图标资源目录`  
        └── js              `javascript脚本资源目录`  
            ├── admin       `总后台管理脚本`  
            ├── app         `APP管理脚本`  
            ├── common      `公共脚本`  
            ├── group       `集团管理脚本`        
            ├── hotel       `物业管理脚本`  
            ├── lib         `第三方类库脚本`  
            │   └── select2 `select2插件脚本`  
            ├── login       `登录控制脚本`   
            ├── rss         `RSS管理脚本`  
            ├── system      `系统管理脚本`  
            └── user        `用户管理脚本`  

*******

#i_group目录结构
.
├── application             `程序主目录`  
│   ├── controllers         `控制器目录`  
│   ├── library             `工具及类库目录`  
│   │   ├── auth            `验证类库`  
│   │   ├── cache           `缓存类库`  
│   │   ├── convertor       `转换器库`  
│   │   ├── enum            `枚举类库`  
│   │   ├── interceptor     `拦截器类库`  
│   │   ├── lang            `多语言字典类`      
│   │   │   ├── en          `英文语言字典`  
│   │   │   └── zh          `中文语言字典`  
│   │   ├── rpc             `接口请求类库`  
│   │   └── util            `工具类库`  
│   ├── models              `模型层目录`  
│   ├── plugins             `程序插件目录`  
│   └── views               `视图层目录`  
│       ├── activity        `集团活动管理视图`  
│       ├── app             `APP管理视图`  
│       ├── article         `编辑器视图`  
│       ├── common          `公共引用视图`  
│       ├── error           `异常视图`  
│       ├── group           `集团管理视图`  
│       ├── help            `帮助管理视图`  
│       ├── hotel           `物业管理视图`  
│       ├── index           `默认页视图`  
│       ├── login           `登录视图`  
│       ├── news            `集团新闻管理视图`  
│       └── notic           `集团通知管理视图`  
├── env                     `配置文件目录`  
└── www                     `入口目录`  
    └── assets              `静态资源目录`  
        ├── css             `层叠样式表资源目录`  
        ├── img             `图片资源目录`  
        │   └── icons       `图标资源目录`  
        └── js              `javascript脚本资源目录`  
            ├── activity    `集团活动管理脚本`  
            ├── app         `APP管理脚本`  
            ├── article     `文章脚本`   
            │   └── ckeditor`ckeditor编辑器目录`   
            ├── common      `公共脚本`  
            ├── group       `集团管理脚本`        
            ├── help        `帮助管理脚本`        
            ├── hotel       `物业管理脚本`  
            ├── lib         `第三方类库脚本`   
            │   ├── plupload`plupload上传目录`  
            │   │   └── js  `plupload上传脚本`  
            │   └── select2 `select2插件脚本`  
            ├── login       `登录控制脚本`   
            ├── news        `集团新闻脚本`   
            └── notic       `集团通知脚本`   
        
*******

#i_iam目录结构
.
├── application             `程序主目录`  
│   ├── controllers         `控制器目录`  
│   ├── library             `工具及类库目录`  
│   │   ├── auth            `验证类库`  
│   │   ├── cache           `缓存类库`  
│   │   ├── convertor       `转换器库`  
│   │   ├── enum            `枚举类库`  
│   │   ├── interceptor     `拦截器类库`  
│   │   ├── lang            `多语言字典类`      
│   │   │   ├── en          `英文语言字典`  
│   │   │   └── zh          `中文语言字典`  
│   │   ├── rpc             `接口请求类库`  
│   │   └── util            `工具类库`  
│   ├── models              `模型层目录`  
│   ├── plugins             `程序插件目录`  
│   └── views               `视图层目录`  
│       ├── activity        `物业活动管理视图`  
│       ├── app             `APP管理视图`  
│       ├── article         `编辑器视图`  
│       ├── ascott          `物业生活视图`  
│       ├── comment         `评论管理视图`  
│       ├── common          `公共引用视图`  
│       ├── error           `异常视图`  
│       ├── feedback        `反馈管理视图`  
│       ├── hotel           `物业管理视图`  
│       ├── index           `默认页视图`  
│       ├── login           `登录视图`  
│       ├── news            `物业新闻视图`  
│       ├── notic           `物业通知视图`  
│       ├── poi             `本地攻略视图`  
│       ├── promotion       `物业促销视图`  
│       ├── room            `房型管理视图`  
│       ├── shopping        `体验购物视图`  
│       ├── showing         `预约看房视图`  
│       └── tel             `电话黄页视图`  
├── env                     `配置文件目录`  
└── www                     `入口目录`  
    └── assets              `静态资源目录`  
        ├── css             `层叠样式表资源目录`  
        ├── img             `图片资源目录`  
        │   ├── icons       `图标资源目录`  
        │   └── jqueryui    `jqueryui资源目录`  
        └── js              `javascript脚本资源目录`  
            ├── activity    `物业活动管理脚本`  
            ├── app         `APP管理脚本`  
            ├── article     `文章脚本`   
            │   └── ckeditor`ckeditor编辑器目录`  
            ├── ascott      `物业生活管理脚本`  
            ├── comment     `评论管理脚本`  
            ├── common      `公共脚本`  
            ├── feedback    `反馈管理脚本`  
            ├── hotel       `物业管理脚本`  
            ├── lib         `第三方类库脚本`   
            │   ├── plupload`plupload上传目录`  
            │   │   └── js  `plupload上传脚本`  
            │   └── select2 `select2插件脚本`  
            ├── login       `登录控制脚本`   
            ├── news        `物业新闻脚本`   
            ├── notic       `物业通知脚本`   
            ├── poi         `本地攻略脚本`   
            ├── promotion   `物业促销脚本`   
            ├── room        `房型管理脚本`   
            ├── shopping    `体验购物脚本`   
            ├── showing     `预约看房脚本`   
            └── tel         `电话黄页脚本`   
